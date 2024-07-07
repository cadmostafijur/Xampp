<?php
// Start the session to access session variables
session_start();

// Check if the user is logged in
if (!isset($_SESSION['username'])) {
    // Redirect the user to the login page if not logged in
    header("Location: login.php");
    exit();
}

// Include database configuration
include 'config.php';

// Initialize variables to store form data
$schedule_id = $rating = $comment = '';
$success_message = '';

// Check if the form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST" && !isset($_POST['redirect'])) {
    // Retrieve form data and sanitize
    $schedule_id = mysqli_real_escape_string($conn, $_POST['schedule_id']);
    $rating = mysqli_real_escape_string($conn, $_POST['rating']);
    $comment = mysqli_real_escape_string($conn, $_POST['comment']);

    // Get the user_id from the session
    $user_id = $_SESSION['user_id'];

    // Insert user review into the database
    $sql = "INSERT INTO user_reviews (user_id, schedule_id, rating, comment, timestamp) 
            VALUES (?, ?, ?, ?, NOW())";
    $stmt = $conn->prepare($sql);

    if (!$stmt) {
        $error_message = "Error preparing statement: " . $conn->error;
    } else {
        // Bind parameters and execute the statement
        $stmt->bind_param("iiis", $user_id, $schedule_id, $rating, $comment);
        if (!$stmt->execute()) {
            $error_message = "Error executing statement: " . $stmt->error;
        } else {
            // Check if the insertion was successful
            if ($stmt->affected_rows > 0) {
                $success_message = "Review submitted successfully.";
            } else {
                $error_message = "Error submitting review. Please try again.";
            }
        }
        // Close statement
        $stmt->close();
    }

    // Redirect to prevent re-submission on page reload
    header("Location: " . $_SERVER['PHP_SELF']);
    exit();
}

// Fetch previous reviews
$sql = "SELECT * FROM user_reviews";
$result = $conn->query($sql);

// Store reviews in an array
$reviews = array();
if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $reviews[] = $row;
    }
}

// Admin reply functionality
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['admin_reply'])) {
    $review_id = $_POST['review_id'];
    $admin_reply = $_POST['admin_reply'];

    // Update admin reply in the database
    $sql = "UPDATE user_reviews SET admin_reply = ? WHERE review_id = ?";
    $stmt = $conn->prepare($sql);

    if (!$stmt) {
        $error_message = "Error preparing statement: " . $conn->error;
    } else {
        // Bind parameters and execute the statement
        $stmt->bind_param("si", $admin_reply, $review_id);
        if (!$stmt->execute()) {
            $error_message = "Error executing statement: " . $stmt->error;
        } else {
            $success_message = "Admin reply added successfully.";
        }
        // Close statement
        $stmt->close();
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Insert Review</title>
    <style>
        /* Cool UI theme CSS */
        body {
            font-family: Arial, sans-serif;
            background-color: #f5f5f5;
            margin: 0;
            padding: 0;
        }

        .container {
            display: flex;
            justify-content: space-between;
            max-width: 800px;
            margin: 20px auto;
            padding: 20px;
            background-color: #fff;
            border-radius: 5px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }

        .form-container {
            flex: 1;
            margin-right: 20px;
        }

        .review-container {
            flex: 1;
        }

        h2 {
            color: #333;
            margin-bottom: 20px;
            text-align: center;
        }

        .form-group {
            margin-bottom: 20px;
        }

        label {
            display: block;
            margin-bottom: 5px;
            color: #666;
        }

        input[type="number"],
        textarea {
            width: 100%;
            padding: 8px;
            margin-top: 5px;
            border: 1px solid #ccc;
            border-radius: 4px;
            box-sizing: border-box;
            resize: vertical;
        }

        button {
            background-color: #5bc0de;
            color: white;
            padding: 10px 20px;
            border: none;
            border-radius: 4px;
            cursor: pointer;
            display: block;
            width: 100%;
            font-size: 16px;
        }

        button:hover {
            background-color: #4da9c9;
        }

        .review {
            margin-bottom: 20px;
            border: 1px solid #ccc;
            padding: 10px;
            border-radius: 5px;
        }

        .review p strong {
            font-weight: bold;
        }

        .success-message {
            background-color: #dff0d8;
            color: #3c763d;
            padding: 10px;
            border-radius: 5px;
            margin-bottom: 10px;
        }

        .error-message {
            background-color: #f2dede;
            color: #a94442;
            padding: 10px;
            border-radius: 5px;
            margin-bottom: 10px;
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="form-container">
            <h2>Review</h2>
            <?php
            // Display success or error message if set
            if (!empty($success_message)) {
                echo "<div class='success-message'>$success_message</div>";
            } elseif (isset($error_message)) {
                echo "<div class='error-message'>$error_message</div>";
            }
            ?>
            <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
                <div class="form-group">
                    <label for="schedule_id">Schedule ID:</label>
                    <input type="number" id="schedule_id" name="schedule_id" required>
                </div>
                <div class="form-group">
                    <label for="rating">Rating:</label>
                    <input type="number" id="rating" name="rating" min="1" max="5" required>
                </div>
                <div class="form-group">
                    <label for="comment">Comment:</label>
                    <textarea id="comment" name="comment" rows="4" required></textarea>
                </div>
                <button type="submit">Submit Review</button>
            </form>
        </div>
        <div class="review-container">
            <h2>Previous Reviews</h2>
            <?php if (!empty($reviews)) : ?>
                <?php foreach ($reviews as $review) : ?>
                    <div class="review">
                        <p><strong>User:</strong> <?php echo $review['user_id']; ?></p>
                        <p><strong>Date:</strong> <?php echo $review['timestamp']; ?></p>
                        <p><strong>Rating:</strong> <?php echo $review['rating']; ?></p>
                        <p><strong>Comment:</strong> <?php echo $review['comment']; ?></p>
                        <!-- Display admin reply field only if admin is logged in -->
                        
                        <?php if (!empty($review['admin_reply'])) : ?>
                            <p><strong>Admin Reply:</strong> <?php echo $review['admin_reply']; ?></p>
                        <?php endif; ?>
                    </div>
                <?php endforeach; ?>
            <?php else : ?>
                <p>No reviews yet.</p>
            <?php endif; ?>
        </div>
    </div>
</body>
</html>
