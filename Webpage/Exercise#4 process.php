<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Team Member Result</title>
    <style>
        body { 
            font-family: Arial, sans-serif; 
            background: linear-gradient(to right, #74ebd5, #ACB6E5);
            padding: 40px; 
            margin: 0;
        }
        .container {
            max-width: 800px;
            margin: auto;
            background: #fff;
            padding: 30px;
            border-radius: 15px;
            box-shadow: 0 8px 20px rgba(0,0,0,0.15);
        }
        h1 { text-align: center; color: #333; }
        .team-card {
            background: #fdfdfd;
            padding: 25px;
            margin-top: 20px;
            border-radius: 12px;
            box-shadow: 0 4px 12px rgba(0,0,0,0.1);
            text-align: center;
        }
        .team-card h2 { margin: 10px 0; color: #0077cc; }
        .team-card p { margin: 6px 0; color: #444; }
        .social a {
            margin: 0 10px;
            text-decoration: none;
            color: #0077cc;
            font-weight: bold;
        }
        .social a:hover { text-decoration: underline; }
        .message {
            text-align: center;
            padding: 15px;
            margin-top: 20px;
            border-radius: 8px;
            font-size: 16px;
        }
        .error { background: #ffe6e6; color: #cc0000; border: 1px solid #ff9999; }
        .info { background: #e6f2ff; color: #005fa3; border: 1px solid #99c2ff; }
    </style>
</head>
<body>
    <div class="container">
        <h1>Search Result</h1>
        <hr>
        <?php
        // === Team data (without image) ===
        $team = [
            "jeffrey" => [
                "name" => "Jeffrey Principe",
                "role" => "Frontend Developer",
                "desc" => "Specializes in creating interactive and visually stunning websites.",
                "phone" => "+63 912 345 6789",
                "email" => "jeffrey@example.com",
                "website" => "www.jeffreyprincipe.dev",
                "social" => [
                    "linkedin" => "#",
                    "facebook" => "#",
                    "twitter" => "#"
                ]
            ],
            "justin" => [
                "name" => "Justin De lara",
                "role" => "Backend Developer",
                "desc" => "Expert in server-side technologies and database management.",
                "phone" => "+63 923 456 7890",
                "email" => "justin@example.com",
                "website" => "www.justindelara.dev",
                "social" => [
                    "linkedin" => "#",
                    "facebook" => "#",
                    "twitter" => "#"
                ]
            ],
            "jaypee" => [
                "name" => "Jaypee Miranda",
                "role" => "UI/UX Designer",
                "desc" => "Creates user-friendly interfaces with eye-catching visuals.",
                "phone" => "+63 934 567 8901",
                "email" => "jaypee@example.com",
                "website" => "www.jaypeemiranda.design",
                "social" => [
                    "linkedin" => "#",
                    "facebook" => "#",
                    "twitter" => "#"
                ]
            ],
            "ralp" => [
                "name" => "Ralp Owen Castillo",
                "role" => "Project Manager",
                "desc" => "Manages projects from start to finish, ensuring teamwork and on-time delivery.",
                "phone" => "+63 945 678 9012",
                "email" => "ralp@example.com",
                "website" => "www.ralpowenpm.com",
                "social" => [
                    "linkedin" => "#",
                    "facebook" => "#",
                    "twitter" => "#"
                ]
            ]
        ];

        // === Get input from POST ===
        if ($_SERVER["REQUEST_METHOD"] == "POST") {
            $search = strtolower(trim($_POST['member']));

            if (array_key_exists($search, $team)) {
                $member = $team[$search];
                echo "<div class='team-card'>";
                echo "<h2>{$member['name']}</h2>";
                echo "<p><strong>Role:</strong> {$member['role']}</p>";
                echo "<p>{$member['desc']}</p>";
                echo "<p><strong>Phone:</strong> {$member['phone']}</p>";
                echo "<p><strong>Email:</strong> {$member['email']}</p>";
                echo "<p><strong>Website:</strong> <a href='http://{$member['website']}' target='_blank'>{$member['website']}</a></p>";
                echo "<div class='social'>
                        <a href='{$member['social']['linkedin']}'>LinkedIn</a>
                        <a href='{$member['social']['facebook']}'>Facebook</a>
                        <a href='{$member['social']['twitter']}'>Twitter</a>
                      </div>";
                echo "</div>";
            } else {
                echo "<div class='message error'>Team member not found. Please try again.</div>";
            }
        } else {
            echo "<div class='message info'>Please use the search form to find a team member.</div>";
        }
        ?>
    </div>
</body>
</html>
