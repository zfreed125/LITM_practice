<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>LITM Media Masterbase</title>

</head>
<style>
    .center {
        text-align: center;
        background-color: violet;
    }
</style>
<body>
    <h1 class="center">Welcome to the LITM Media Masterbase</h1>
    <form action="create.php" method="POST">
        <input type="text" name="first_name" placeholder="Firstname">
        <br>
        <br>
        <input type="text" name="last_name" placeholder="Lastname">
        <br>
        <br>
        <input type="text" name="email" placeholder="Email">
        <br>
        <br>
        <input type="checkbox" id="activity" name="activity" value="active">
        <label for="active">Active</label>
        <br>
        <br>
        <input type="checkbox" id="activity" name="activity" value="non-active">
        <label for="non-active">Non-Active</label>
        <br>
        <br>
        <label for="client_type">Client_Type:</label>
            <select name="client_type" id="client_type">
                <option value="host">Host</option>
                <option value="employee">Employee</option>
                <option value="guest">Guest</option>
                <option value="organization">Organization</option>
                <option value="other">Other</option>
            </select>
         <br>
         <br>
         <button type="submit" name="submit">Submit</button>

    </form>
</body>
</html>