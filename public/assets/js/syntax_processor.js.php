<!-- Syntax processor -->
<script type="text/javascript">
  // UPDATE MUST ALSO BE DONE IN THE PHP VERSION IN syntax_processor_helper.php
  function replaceEnvironmentSyntax(input) {
    // console.log(input);
    // Regular expression to match the pattern [ variable ]
    return input.replace(/\[\s*(\w+)\s*\]/g, function(match, key) {
      switch (key) {
        case "base_url":
          return "<?= base_url() ?>"; // Assuming baseUrl is a function defined elsewhere
          // Add more variables here as needed
          // case 'other_variable':
          //     return 'your_value_here';
        default:
          return match; // Return original if no match
      }
    });
  }
</script>
<!-- End of syntax processor -->