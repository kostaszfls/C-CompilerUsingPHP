<!DOCTYPE html>
<html>
<head>
    <title>C Code Compiler</title>
</head>
<body>
    <h1>C Code Compiler</h1>

    <form method="post" action="<?php echo $_SERVER['PHP_SELF']; ?>">
        <textarea name="code" rows="10" cols="50" placeholder="Enter C code here"></textarea><br>
        <input type="submit" name="submit" value="Compile and Run">
    </form>

    <?php
    if ($_SERVER["REQUEST_METHOD"] === "POST" && isset($_POST["submit"])) {
        // Get the user's C code from the form
        $cCode = $_POST["code"];

        // Save the C code to a file
        $cFileName = 'user_code.c';
        file_put_contents($cFileName, $cCode);

        // Compile the user's C code using the system's C compiler
        $executableName = 'user_code';  // Name of the compiled executable
        $compilerCommand = "gcc $cFileName -o $executableName";
        exec($compilerCommand, $compilerOutput, $compilerExitCode);

        if ($compilerExitCode === 0) {
            // Compilation successful, execute the compiled program
            $output = shell_exec("./$executableName");
            echo "<h2>Output:</h2>";
            echo "<pre>$output</pre>";
        } else {
            // Compilation failed, display the compiler errors
            echo "<h2>Compilation failed. Compiler output:</h2>";
            echo "<pre>" . implode("\n", $compilerOutput) . "</pre>";
        }

        // Clean up: delete the C source file and the compiled executable
        unlink($cFileName);
        unlink($executableName);
    }
    ?>
</body>
</html>
