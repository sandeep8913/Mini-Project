<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Student Fee and Fine Management</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <style>
        * {
            box-sizing: border-box;
            margin: 0;
            padding: 0;
            font-family: 'Arial', sans-serif;
        }

        body {
            display: flex;
            flex-direction: column;
            min-height: 100vh;
            background-color: #f0f2f5;
        }

        header {
            background-color: #007bff;
            color: white;
            padding: 20px;
            font-size: 24px;
            text-align: center;
        }

        main {
            flex: 1;
            display: flex;
            flex-direction: column;
            justify-content: center;
            align-items: center;
            padding: 20px;
        }

        .search-container {
            background: white;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            margin-bottom: 20px;
        }

        input[type="text"] {
            padding: 10px;
            font-size: 16px;
            margin-right: 10px;
            border: 1px solid #ccc;
            border-radius: 4px;
            transition: border-color 0.3s ease;
        }

        input[type="text"]:focus {
            border-color: #007bff;
        }

        button {
            padding: 10px 20px;
            background-color: #007bff;
            color: white;
            border: none;
            border-radius: 4px;
            cursor: pointer;
            font-size: 16px;
            transition: background-color 0.3s ease;
        }

        button:hover {
            background-color: #0056b3;
        }

        .result-container {
            display: none;
            flex-direction: column;
            align-items: center;
            background: white;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        }

        .result-container form {
            display: flex;
            flex-direction: column;
            gap: 10px;
        }

        .result-container label {
            font-weight: bold;
        }

        footer {
            background-color: #007bff;
            color: white;
            padding: 10px;
            text-align: center;
        }

        @media (max-width: 600px) {
            input[type="text"] {
                margin: 0 0 10px 0;
                width: 100%;
            }

            button {
                width: 100%;
            }

            .search-container,
            .result-container {
                width: 100%;
                padding: 20px 10px;
            }
        }
    </style>
</head>
<body>
    <header>
        <h1>Student Fee and Fine Management</h1>
    </header>
    <main>
        <div class="search-container">
            <form id="search-form">
                <label for="roll">Enter Roll Number:</label>
                <input type="text" id="roll" name="roll" required>
                <button type="submit">Search</button>
            </form>
        </div>
        <div class="result-container" id="result-container">
            <!-- Result will be displayed here -->
        </div>
        <a href="staff.html" class="btn btn-secondary">Back</a>
    </main>
    <footer>
        <p>GCET</p>
    </footer>
    <script>
        document.getElementById('search-form').addEventListener('submit', function(event) {
            event.preventDefault();
            let roll = document.getElementById('roll').value;

            fetch(`feesearch.php?roll=${roll}`)
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        document.getElementById('result-container').innerHTML = `
                            <form id="update-form">
                                <label>Roll: <input type="text" name="roll" value="${data.roll}" readonly></label>
                                <label>Fee: <input type="text" name="fee" value="${data.fee}"></label>
                                <label>Fine: <input type="text" name="fine" value="${data.fine}"></label>
                                <button type="submit">Update</button>
                            </form>
                        `;
                        document.getElementById('result-container').style.display = 'flex';

                        document.getElementById('update-form').addEventListener('submit', function(event) {
                            event.preventDefault();
                            let formData = new FormData(this);

                            fetch('feeupdate.php', {
                                method: 'POST',
                                body: formData
                            })
                            .then(response => response.json())
                            .then(data => {
                                if (data.success) {
                                    alert('Record updated successfully');
                                } else {
                                    alert('Failed to update record');
                                }
                            });
                        });
                    } else {
                        alert('No record found');
                    }
                });
        });
    </script>
</body>
</html>
