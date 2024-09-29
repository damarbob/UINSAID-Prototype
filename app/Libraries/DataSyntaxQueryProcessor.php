<?php

namespace App\Libraries;

class DataSyntaxQueryProcessor
{
    protected $db;

    public function __construct()
    {
        $this->db = \Config\Database::connect();  // Load the CI4 database connection
    }

    // Main function to process the custom data syntax in content
    public function processDataSyntax($content)
    {
        // Use regex to find the custom data syntax block: /* data {...} data */
        $pattern = '/\/\* data (.*?) data \*\//s';

        // Replace the found custom data syntax with actual data for all occurrences
        return preg_replace_callback($pattern, function ($matches) {
            // The JSON object is inside the first capturing group
            $jsonData = ($matches[1]);

            // Sanitize JSON: remove line breaks and other unnecessary whitespaces
            $sanitizedJson = preg_replace('/\s+/', ' ', $jsonData);
            $sanitizedJson = trim($sanitizedJson);

            // Decode the JSON object to get the query parameters
            $queryParams = json_decode($sanitizedJson, true);

            if (json_last_error() !== JSON_ERROR_NONE || !$queryParams) {
                return json_encode(['error' => 'Invalid JSON syntax: ' . $jsonData]);
            }

            // Perform the query and get the data
            $data = $this->fetchDataFromDatabase($queryParams);

            // Return the fetched data as a JSON string, replacing the custom syntax
            return json_encode($data);
        }, $content);
    }

    // Function to execute the query and fetch data from the database based on the custom syntax
    protected function fetchDataFromDatabase($queryParams)
    {
        if (isset($queryParams['query'])) {

            $rawQuery = trim($queryParams['query']);

            // Ensure the query starts with 'SELECT'
            if (stripos($rawQuery, 'SELECT') !== 0) {
                return ['error' => 'Only SELECT queries are allowed for raw SQL.'];
            }

            // Execute the provided raw SQL query
            $query = $this->db->query($rawQuery);
            $result = $query->getResultArray();

            return $this->sanitizeData($result);
        }

        if (!isset($queryParams['table'])) {
            return ['error' => 'Table name not specified'];
        }

        // Get the table name
        $table = $queryParams['table'];

        // Start building the query
        $builder = $this->db->table($table);

        // Apply the SELECT clause if present, otherwise select all (*)
        if (isset($queryParams['select']) && !empty($queryParams['select'])) {
            $builder->select($queryParams['select']);
        } else {
            $builder->select('*');
        }

        // Apply WHERE conditions (supports complex conditions with arrays)
        if (isset($queryParams['where']) && is_array($queryParams['where'])) {
            foreach ($queryParams['where'] as $condition) {
                if (is_array($condition) && isset($condition['column'], $condition['operator'], $condition['value'])) {
                    $builder->where($condition['column'] . ' ' . $condition['operator'], $condition['value']);
                } else {
                    // Handle standard where key-value pairs
                    $builder->where($condition);
                }
            }
        }

        // Apply LIKE conditions (supports complex LIKE clauses)
        if (isset($queryParams['like']) && is_array($queryParams['like'])) {
            foreach ($queryParams['like'] as $field => $value) {
                $builder->like($field, $value);
            }
        }

        // Apply JOINs if specified (supports multiple joins)
        if (isset($queryParams['joins']) && is_array($queryParams['joins'])) {
            foreach ($queryParams['joins'] as $join) {
                if (isset($join['table'], $join['condition'], $join['type'])) {
                    $builder->join($join['table'], $join['condition'], $join['type']);
                }
            }
        }

        // Apply GROUP BY if specified
        if (isset($queryParams['groupby'])) {
            $builder->groupBy($queryParams['groupby']);
        }

        // Apply HAVING if specified (similar to WHERE but for grouped data)
        if (isset($queryParams['having']) && is_array($queryParams['having'])) {
            foreach ($queryParams['having'] as $condition) {
                if (is_array($condition) && isset($condition['column'], $condition['operator'], $condition['value'])) {
                    $builder->having($condition['column'] . ' ' . $condition['operator'], $condition['value']);
                } else {
                    $builder->having($condition);
                }
            }
        }

        // Apply ORDER BY if specified
        if (isset($queryParams['orderby'])) {
            $builder->orderBy($queryParams['orderby']);
        }

        // Apply LIMIT and OFFSET for pagination
        if (isset($queryParams['limit'])) {
            $limit = $queryParams['limit'];
            $offset = isset($queryParams['offset']) ? $queryParams['offset'] : 0;
            $builder->limit($limit, $offset);
        }

        // Execute the query and get the result
        $result = $builder->get()->getResultArray();

        return $this->sanitizeData($result);
    }


    // Function to sanitize data before JSON encoding
    protected function sanitizeData($data)
    {
        return array_map(function ($item) {
            return array_map(function ($value) {
                // Escape HTML entities
                $value = htmlspecialchars($value, ENT_QUOTES, 'UTF-8');

                // Handle new lines and other special characters
                return str_replace(["\r\n", "\r", "\n"], ' ', $value); // Replace new line characters with a space
            }, $item);
        }, $data);
    }

    // Helper function to sanitize the JSON string
    protected function sanitizeJsonString($json)
    {
        // Remove new lines, tabs, and unescaped quotes
        $json = preg_replace('/\r|\n|\t/', '', $json);
        $json = str_replace('\"', '"', $json);
        $json = addslashes($json); // Escape quotes and special characters

        return $json;
    }
}
