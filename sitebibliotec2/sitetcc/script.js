const computersContainer = document.getElementById('computers');
const refreshButton = document.getElementById('refreshButton');

function fetchComputerData() {
  // Fetch computer data from server-side script (e.g., 'get_computer_data.php')
  fetch('get_computer_data.php')
    .then(response => response.json())
    .then(data => {
      displayComputers(data);
    })
    .catch(error => {
      console.error('Error fetching computer data:', error);
    });
}

function displayComputers(data) {
  computersContainer.innerHTML = ''; // Clear previous computers

  data.forEach(computer => {
    const computerElement = document.createElement('div');
    computerElement.classList.add('computer');

    const computerName = document.createElement('h2');
    computerName.textContent = `Computador ${computer.id}`;
    computerElement.appendChild(computerName);

    const statusElement = document.createElement('p');
    statusElement.classList.add(computer.status === 'livre' ? 'status-available' : 'status-occupied');
    statusElement.textContent = `Status: ${computer.status}`;
    computerElement.appendChild(statusElement);

    computersContainer.appendChild(computerElement);
  });
}

fetchComputerData(); // Load initial data on page load

refreshButton.addEventListener('click', fetchComputerData); // Refresh on button click
