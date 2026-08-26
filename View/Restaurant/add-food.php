
<html>
<head>
    <title>Add Food</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>

<fieldset>
    <legend>Add Food</legend>

    <form>

        <label>Food Name:</label>
        <input type="text" required>

        <label>Price:</label>
        <input type="number" required>

        <label>Description:</label>
        <textarea required></textarea>

        <label>Availability:</label>
        <select>
            <option>Available</option>
            <option>Not Available</option>
        </select>

        <button type="submit">Add Food</button>

    </form>
</fieldset>
<button>
Back to Dashboard </button>

</body>
</html>