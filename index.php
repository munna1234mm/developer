<?php
// Handle upload
$message = "";
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $project = preg_replace('/[^A-Za-z0-9_\-]/', '_', $_POST['project']);
    if (!is_dir("uploads")) {
        mkdir("uploads");
    }
    $folder = "uploads/" . $project;
    if (!is_dir($folder)) {
        mkdir($folder);
    }

    // Handle file upload
    if (!empty($_FILES['file']['name'])) {
        $target = $folder . "/" . basename($_FILES['file']['name']);
        if (move_uploaded_file($_FILES['file']['tmp_name'], $target)) {
            $message = "✅ File uploaded successfully: " . htmlspecialchars($_FILES['file']['name']);
        } else {
            $message = "❌ File upload failed.";
        }
    }

    // Handle code paste
    if (!empty($_POST['code'])) {
        $codeFile = $folder . "/pasted_code.txt";
        file_put_contents($codeFile, $_POST['code']);
        $message .= "<br>✅ Code saved to pasted_code.txt";
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Code Hosting Web</title>
  <style>
    body {
      font-family: Arial, sans-serif;
      background: #1e1e1e;
      color: #f5f5f5;
      margin: 0;
      padding: 0;
    }
    header {
      background: #0078d7;
      padding: 15px;
      text-align: center;
      font-size: 22px;
      font-weight: bold;
    }
    .container {
      max-width: 800px;
      margin: 30px auto;
      background: #2d2d2d;
      padding: 20px;
      border-radius: 10px;
      box-shadow: 0 0 10px #000;
    }
    input, textarea, button {
      width: 100%;
      padding: 10px;
      margin: 8px 0;
      border-radius: 5px;
      border: none;
      font-size: 16px;
    }
    input, textarea {
      background: #1a1a1a;
      color: #f5f5f5;
    }
    button {
      background: #0078d7;
      color: #fff;
      cursor: pointer;
      transition: 0.3s;
    }
    button:hover {
      background: #005a9e;
    }
    .message {
      background: #333;
      padding: 10px;
      border-left: 4px solid #0078d7;
      margin-top: 15px;
    }
  </style>
</head>
<body>
  <header>🚀 Code Hosting Web</header>
  <div class="container">
    <h2>Upload Project or Paste Code</h2>
    <form method="post" enctype="multipart/form-data">
      <label>Project/Doom Name:</label>
      <input type="text" name="project" required placeholder="Enter project name">
      
      <label>Upload File:</label>
      <input type="file" name="file">
      
      <label>Or Paste Your Code:</label>
      <textarea name="code" rows="10" placeholder="Paste your code here..."></textarea>
      
      <button type="submit">Submit</button>
    </form>

    <?php if (!empty($message)) { ?>
      <div class="message"><?php echo $message; ?></div>
    <?php } ?>
  </div>
</body>
</html>
