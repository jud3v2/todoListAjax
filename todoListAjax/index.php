<!doctype html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="stylesheet" href="app.css">
    <title>Todos Ajax PHP</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body>
<div class="flex justify-center">
    <div class="w-full max-w-xs">
        <h1 class="text-7xl font-black text-center my-5">Todos</h1>
        <form class="bg-white shadow-md rounded px-8 pt-6 pb-8 mb-4" id="addTodoForm" action="Todos.php" method="POST">
            <div class="mb-4">
                <label class="block text-gray-700 text-sm font-bold mb-2" for="title">Title of todo</label>
                <input type="text"
                       class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline"
                       name="title" id="title" placeholder="Title">
            </div>
            <div class="mb-6">
                <label class="block text-gray-700 text-sm font-bold mb-2" for="description">Description</label>
                <input type="text" name="description"
                       class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline"
                       id="description" placeholder="Description">
            </div>
            <button class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded" type="submit" id="submit">Add</button>
        </form>
    </div>
</div>

    <div id="todos-not-completed ml-5">
        <h2 class="font-bold text-3xl">Todos not completed</h2>
        <ul id="todosList-no-completed"></ul>
</div>
    <div id="todos-completed ml-5">
        <h2 class="font-bold text-3xl">Todos completed</h2>
        <ul id="todosList-completed"></ul>
</div>
<script src="script.js"></script>
</body>
</html>