<?php

namespace App\Helpers;

if (!function_exists('replaceMetaSyntax')) {
    /**
     * Replace meta syntax in the HTML source with corresponding values from the meta source.
     *
     * This function decodes a JSON string containing meta data and replaces occurrences of 
     * meta syntax in the HTML source with the corresponding 'value' from the meta data.
     * 
     * @param string $htmlSource The HTML content containing meta syntax to be replaced.
     * @param string $metaSource A JSON string representing an array of meta data.
     * 
     * @return string The modified HTML content with replaced meta values.
     */
    function replaceMetaSyntax($htmlSource, $metaSource)
    {
        // Decode the meta source JSON into an associative array
        $metaDataArray = json_decode($metaSource, true);

        // If metaDataArray is null
        if (!$metaDataArray) {
            // dd($htmlSource);
            return $htmlSource; // Return initial HTML as is without modification
        }

        // Create an associative array for quick lookup by ID
        $metaDataMap = [];
        foreach ($metaDataArray as $metaData) {
            $metaDataMap[$metaData['id']] = $metaData;
        }

        // Function to replace meta syntax with values
        $pattern = '/\/\* meta \{(.*?)\} meta \*\//';
        $replacementCallback = function ($matches) use ($metaDataMap) {
            // Decode the meta data from the match
            $meta = json_decode('{' . $matches[1] . '}', true);

            // Check if the meta ID exists, if not, return an empty string
            if (!isset($metaDataMap[$meta['id']])) {
                return ''; // Set to empty if not found
            }

            $metaData = $metaDataMap[$meta['id']];
            $value = $metaData['value'];
            $output = '';

            // Handle different types
            switch ($meta['tipe']) {
                case 'text':
                case 'number':
                case 'email':
                case 'password':
                case 'color':
                case 'textarea':
                    $output = htmlspecialchars($value); // Use htmlspecialchars for safety
                    break;

                case 'datetime-local':
                    $output = date('M Y, H:i', strtotime($value));
                    break;

                case 'radio':
                    // Assuming the value is one of the options' values
                    foreach ($meta['options'] as $option) {
                        if ($option['value'] === $value) {
                            $output = $option['label'];
                            break;
                        }
                    }
                    break;

                case 'checkbox':
                    $output = $value ? $value : ''; // 'on' for checked, empty string for unchecked or not found
                    break;

                case 'file':
                    $output = is_array($value) ? implode(', ', $value) : $value;
                    break;

                case 'select':
                    // Assuming the value is one of the options' values
                    foreach ($meta['options'] as $option) {
                        if ($option['value'] === $value) {
                            $output = $option['label'];
                            break;
                        }
                    }
                    break;

                default:
                    $output = htmlspecialchars($value); // Default case
                    break;
            }

            return $output;
        };

        // Replace the meta syntax in the HTML source
        $result = preg_replace_callback($pattern, $replacementCallback, $htmlSource);

        return $result;
    }
}

if (!function_exists('replaceMetaSyntaxWithDefault')) {
    /**
     * Replace meta syntax in the HTML source with the field 'value' from the meta syntax.
     *
     * This function searches for meta syntax within the provided HTML source and replaces
     * it with the 'value' field from the meta data, returning an empty string if no value is found.
     *
     * @param string $htmlSource The HTML content containing meta syntax to be replaced.
     *
     * @return string The modified HTML content with replaced meta values or an empty string if not found.
     */
    function replaceMetaSyntaxWithDefault($htmlSource)
    {
        // Regular expression to match the meta syntax
        $pattern = '/\/\* meta \{(.*?)\} meta \*\//';

        // Replacement callback function
        $replacementCallback = function ($matches) {
            // Decode the meta data from the match
            $meta = json_decode('{' . $matches[1] . '}', true);

            // If value exists in the meta, return it; otherwise, return an empty string
            return isset($meta['value']) ? htmlspecialchars($meta['value']) : '';
        };

        // Replace the meta syntax in the HTML source
        $result = preg_replace_callback($pattern, $replacementCallback, $htmlSource);

        return $result;
    }
}

if (!function_exists('replaceAttributesSyntax')) {
    function replaceAttributesSyntax($content, $attrJsonString)
    {
        // Decode the JSON string into an associative array
        $jsonArray = json_decode($attrJsonString, true);

        // Regular expression to match the attr placeholder pattern (supports both single and double quotes)
        $pattern = '/\/\*\s*attr\s*\([\'"]([^\'"]+)[\'"]\)\s*attr\s*\*\//';

        // Replace the attr placeholders
        $content = preg_replace_callback($pattern, function ($matches) use ($jsonArray) {
            $key = $matches[1];
            return isset($jsonArray[$key]) ? $jsonArray[$key] : $matches[0];
        }, $content);

        return $content;
    }
}

if (!function_exists('hasAttributesSyntax')) {
    // UNUSED
    function hasAttributesSyntax($content)
    {
        // Regular expression to match the attr placeholder pattern (supports both single and double quotes)
        $pattern = '/\/\*\s*attr\s*\([\'"]([^\'"]+)[\'"]\)\s*attr\s*\*\//';

        // Check if there's a match in the content
        return preg_match($pattern, $content) === 1;
    }
}

if (!function_exists('replaceEnvironmentSyntax')) {
    function replaceEnvironmentSyntax($input)
    {
        // Example: [ base_url ]
        return preg_replace_callback('/\[\s*(\w+)\s*\]/', function ($matches) {
            switch ($matches[1]) {
                case 'base_url':
                    return base_url();
                    // Add more variables here as needed
                    // case 'other_variable':
                    //     return 'your_value_here';
                case 'now':
                    return date('Y-m-d H:i:s');
                default:
                    return $matches[0]; // Return original if no match
            }
        }, $input);
    }
}
