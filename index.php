<?php ?>
<!DOCTYPE html>
<html>
<head>
    <title>AI Client Discovery Form</title>
    <meta charset="UTF-8">
    <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
    <style>
        body{
            font-family:Arial;
            background:#f4f7fb;
            padding:40px;
        }
        .container{
            max-width:700px;
            margin:auto;
            background:#fff;
            padding:30px;
            border-radius:12px;
            box-shadow:0 2px 10px rgba(0,0,0,0.1);
        }
        h1{
            margin-bottom:10px;
        }
        input,select,textarea{
            width:100%;
            padding:12px;
            margin-top:10px;
            margin-bottom:20px;
            border:1px solid #ccc;
            border-radius:8px;
        }
        button{
            background:#111827;
            color:#fff;
            padding:12px 20px;
            border:none;
            border-radius:8px;
            cursor:pointer;
        }
        .msg{
            margin-top:20px;
            padding:15px;
            border-radius:8px;
            display:none;
        }
        .success{
            background:#d1fae5;
            color:#065f46;
        }
    </style>
</head>
<body>

<div class="container">
    <h1>AiTech Solutions</h1>
    <p>Client Discovery + AI Proposal Generator</p>

    <form id="leadForm">
        <input type="text" name="name" placeholder="Your Name" required>

        <input type="email" name="email" placeholder="Email Address" required>

        <input type="text" name="company" placeholder="Company Name" required>

        <select name="industry" required>
            <option value="">Select Industry</option>
            <option>E-commerce</option>
            <option>Healthcare</option>
            <option>Education</option>
            <option>Finance</option>
        </select>

        <textarea name="goal" placeholder="What problem are you trying to solve?" required></textarea>

        <select name="solution" required>
            <option value="">Solution Needed</option>
            <option>Mobile App</option>
            <option>Web Platform</option>
            <option>API Integration</option>
            <option>AI Feature</option>
            <option>Custom ERP</option>
        </select>

        <button type="submit">Submit</button>
    </form>

    <div class="msg success" id="successMsg"></div>
</div>

<script>
$("#leadForm").submit(function(e){
    e.preventDefault();

    $.ajax({
        url: "process.php",
        type: "POST",
        data: $(this).serialize(),
        success: function(response){
            $("#successMsg").html(response).show();
            $("#leadForm")[0].reset();
        }
    });
});
</script>

</body>
</html>
