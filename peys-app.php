<?php
// Start the session to handle form submissions
session_start();

// Initialize variables for photo size and border color
$photo_size = isset($_POST['photo_size']) ? $_POST['photo_size'] : 60; // Default size set to 60
$border_color = '';
$size = '';

// Check if the form has been submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Get the selected photo size and border color from the form
    $photo_size = $_POST['photo_size'];
    $border_color = $_POST['border_color'];

    // Get the actual size in pixels based on user selection and double it for display
    $size = intval($photo_size) * 2 . 'px'; // Convert to integer, double it, and append 'px'
} else {
    // Set default size for image display when page loads
    $size = '120px'; // Default size (60 * 2)
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Peys App</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 20px;
            text-align: left; /* Align text to left */
        }
        .form-container {
            max-width: 624px; /* Increased size by 30% from 480px */
            margin-left: 0; /* Align to left */
        }
        label {
            display: inline-block; /* Change to inline-block for alignment */
            margin-right: 10px; /* Space between label and slider */
            vertical-align: middle; /* Align vertically with slider */
        }
        button {
            margin-top: 20px; /* Space above button */
            padding: 5px 10px; /* Smaller padding for a smaller button */
            font-size: 14px; /* Smaller font size for better visibility */
        }
        .result {
            margin-top: 20px;
            border: 5px solid <?php echo htmlspecialchars($border_color); ?>;
            width: <?php echo htmlspecialchars($size); ?>;
            height: <?php echo htmlspecialchars($size); ?>;
            background-color: lightgray; /* Placeholder for photo */
            display: block; /* Always show result box */
            position: relative; /* For positioning child elements */
        }
        .image {
            max-width: 100%;
            max-height: 100%;
            position: absolute; /* Position image within result box */
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%); /* Center image */
        }
        .slider-container {
            display: flex;
            align-items: center; /* Align output with slider */
        }
    </style>
</head>
<body>

<div class="form-container">
    <h2>Peys App</h2>
    <form action="" method="POST">
        <div class="slider-container">
            <label for="photo_size">Select Photo Size:</label>
            <input type="range" name="photo_size" id="photo_size" min="10" max="100" value="<?php echo htmlspecialchars($photo_size); ?>" required oninput="this.nextElementSibling.value = this.value">
        </div>

        <label for="border_color">Select Border Color:</label>
        <input type="color" name="border_color" id="border_color" value="<?php echo htmlspecialchars($border_color); ?>" required>

        <!-- Process button positioned below -->
        <button type="submit">Process</button>
    </form>

    <!-- Always display results -->
    <div class='result'>
        <!-- Display the image -->
        <?php if (file_exists("images/alejandro.png")): ?>
            <img src="images/alejandro.png" alt="Alejandro Image" class="image">
        <?php else: ?>
            <p style="color:red;">Image not found. Please check the file path.</p>
            <!-- Debugging information -->
            <p>Debugging Info:</p>
            <p>Current Directory: <?php echo getcwd(); ?></p>
            <p>Expected Path: images/alejandro.png</p>
            <p>Full Path: <?php echo realpath("images/alejandro.png"); ?></p>
        <?php endif; ?>
    </div>
</div>

<script>
// Allow keyboard arrow keys to adjust the slider value by increments of 10
document.addEventListener('keydown', function(event) {
    const slider = document.getElementById('photo_size');
    
    if (event.key === "ArrowRight") { // Right arrow key
        slider.value = Math.min(100, parseInt(slider.value) + 10); // Increase by 10
        slider.dispatchEvent(new Event('input')); // Trigger input event to update output
    } else if (event.key === "ArrowLeft") { // Left arrow key
        slider.value = Math.max(10, parseInt(slider.value) - 10); // Decrease by 10
        slider.dispatchEvent(new Event('input')); // Trigger input event to update output
    }
});

// Automatically focus on the slider when the page loads
window.onload = function() {
    document.getElementById('photo_size').focus();
};
</script>

</body>
</html>