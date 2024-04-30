const generateTodosElement = (data, completedElement, unCompletedElement) => {
        completedElement.innerHTML = '';
        unCompletedElement.innerHTML = '';
        data.map((todo) => {
                if (todo.completed === 1) {
                        completedElement.innerHTML += `
                        <li class="m-5">
                                <p class="text-xl font-black">${todo.title}</p>
                                <p class="text-lg font-black">${todo.description}</p>
                                <button class="move-to-completed bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded" id="uncompleted-${todo.id}">move to uncomplete</button>
                                <button class="delete bg-red-500 hover:bg-red-700 text-white font-bold py-2 px-4 rounded" id="uncompleted-${todo.id}">delete</button>
                        </li>`
                } else {
                        unCompletedElement.innerHTML += `<li class="m-5">
                                <p class="text-xl font-black">${todo.title}</p>
                                <p class="text-lg font-black">${todo.description}</p>
                                  <button class="move-to-completed bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded" id="uncompleted-${todo.id}">move to complete</button>
                                <button class="delete bg-red-500 hover:bg-red-700 text-white font-bold py-2 px-4 rounded"  id="uncompleted-${todo.id}">delete</button>
                        </li>`
                }
        });

        giveEventListeners();
}

const toggleTodos = async (id) => {
        const url = 'http://localhost:8000/Todos.php?id=' + id + "&action=update";
        const response = await fetch(url, {
                method: 'POST',
                headers: {
                        'Content-Type': 'application/json'
                }
        })
        await response.json();
        await fetchTodosAndRefreshAsyncData();
}

const deleteTodo = async (id) => {
        const url = 'http://localhost:8000/Todos.php?id=' + id + "&action=delete";
        const response = await fetch(url, {
                method: 'POST',
                headers: {
                        'Content-Type': 'application/json'
                }
        })
        await response.json();
        await fetchTodosAndRefreshAsyncData();
}

const fetchTodosAndRefreshAsyncData = async () => {
        const todosNotCompletedElement = document.querySelector('#todosList-no-completed')
        const todosCompletedElement = document.querySelector('#todosList-completed')
        const url = 'http://localhost:8000/Todos.php';
        const response = await fetch(url);
        const data = await response.json();
        if (data.length > 0) {
                generateTodosElement(data, todosCompletedElement, todosNotCompletedElement)
        } else {
                todosNotCompletedElement.innerHTML = '<p>No todos</p>'
                todosCompletedElement.innerHTML = '<p>No todos</p>'
        }
}

const giveEventListeners = () => {
        document.querySelectorAll('.move-to-completed').forEach((button) => {
                button.onclick = async (event) => {
                        const id = event.target.id.split('-')[1]
                        await toggleTodos(id)
                }
        });

        document.querySelectorAll('.delete').forEach((button) => {
                button.onclick = async (event) => {
                        const id = event.target.id.split('-')[1]
                        await deleteTodo(id)
                }
        });
};

document.addEventListener('DOMContentLoaded', async function () {
        await fetchTodosAndRefreshAsyncData()
        const buttonElement = document.querySelector('#submit');

        buttonElement.onclick = async (event) => {
                event.preventDefault();
                const title = document.querySelector('#title').value;
                const description = document.querySelector('#description').value;
                const url = 'http://localhost:8000/Todos.php';
                const response = await fetch(url, {
                        method: 'POST',
                        headers: {
                                'Content-Type': 'application/json'
                        },
                        body: JSON.stringify({
                                title,
                                description
                        })
                })
                title.value = '';
                description.value = '';
                await response.json();
                await fetchTodosAndRefreshAsyncData()
        }

        giveEventListeners()
});