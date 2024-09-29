<?php
session_start();
include 'includes/db.php'; // Database connection

// Check if the user is logged in
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

$user_id = $_SESSION['user_id'];
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Chat App</title>
    <link rel="stylesheet" href="assets/css/chat.css">
</head>
<body>
    <?php include "nav.php";?>
    <div class="chat-container">
        <div class="user-list">
            <h3>Users</h3>
            <ul id="users">
                <?php
                // Fetch the list of users and their status (active or offline)
                $query = "SELECT id, username, status FROM users WHERE id != '$user_id'";
                $result = mysqli_query($conn, $query);
                while ($row = mysqli_fetch_assoc($result)) {
                    $status = $row['status'] == 'online' ? 'Active' : 'Offline';
                    echo "<li data-id='{$row['id']}'>
                            <span>{$row['username']}</span> 
                            <span style='color: " . ($status == 'Active' ? 'green' : 'red') . ";'>($status)</span>
                          </li>";
                }
                ?>
            </ul>
        </div>
        
        <div class="chat-box">
            <div id="messages">
                <!-- Messages will be loaded here -->
            </div>
            <form id="messageForm">
                <input type="text" id="messageInput" placeholder="Type your message" required>
                <button type="submit">Send</button>
            </form>
        </div>
    </div>

    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
    <script>
        $(document).ready(function() {
    let receiverId = null;
    let receiverName = null;

    // Handle user selection
    $('#users').on('click', 'li', function() {
        receiverId = $(this).data('id');
        receiverName = $(this).find('span:first').text();
        $('#selected-user').text(`Chatting with ${receiverName} (ID: ${receiverId})`);
        loadMessages(receiverId);
    });

    // Handle sending messages
    $('#messageForm').on('submit', function(e) {
        e.preventDefault();
        let message = $('#messageInput').val();

        // Debugging: Log message and receiverId
        console.log("Message:", message);
        console.log("Receiver ID:", receiverId);

        if (receiverId && message.trim() !== '') {
            $.post('ajax/send_message.php', {receiver_id: receiverId, message: message}, function(response) {
                console.log("Server Response:", response);  // Log the server's response
                $('#messageInput').val('');  // Clear the input field
                loadMessages(receiverId);    // Refresh the chat
            }).fail(function(xhr, status, error) {
                console.log("Error:", error);  // Log any error
            });
        } else {
            console.log("Message or receiver ID is missing");
        }
    });

    // Load messages for the selected user
    function loadMessages(receiverId) {
        $.get('ajax/get_messages.php', {receiver_id: receiverId}, function(data) {
            $('#messages').html(data);
        });
    }
});

    </script>
    <style>
        .navbar {
            background-color: #333;
            color: #fff;
            padding: 1rem;
            text-align: center;
        }
        .navbar-brand {
            font-size: 1.5rem;
            margin-right: 1rem;
        }
        .navbar-text {
            font-size: 1rem;
        }
    </style>
</body>
</html>