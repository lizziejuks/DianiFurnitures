<?php
// footer.php: Include this file at the bottom of every page.
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <style>
        /* Footer Styles */
        .footer {
            background-color: #29AB87; /* Jungle Green background */
            color: white;
            text-align: center;
            padding: 20px;
            position: relative;
            width: 100%;
        }

        /* Sticky footer that sticks to the bottom of the page */
        html, body {
            height: 100%;
            margin: 0;
            display: flex;
            flex-direction: column;
        }

        .content {
            flex: 1; /* Allow content to take available space, pushing footer to the bottom */
        }

        /* Footer Text Styling */
        .footer p {
            margin: 0;
            font-size: 14px;
        }
    </style>
</head>
<body>
    <div class="content">
        <!-- Content of your page goes here -->
    </div>

    <!-- Footer -->
    <footer class="footer">
        <p>&copy; 2024 Furniture Store. All rights reserved.</p>
    </footer>
</body>
</html>
