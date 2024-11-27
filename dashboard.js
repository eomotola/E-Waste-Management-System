// SIDEBAR TOGGLE

let sidebarOpen = false;
const sidebar = document.getElementById('sidebar');

function openSidebar() {
  if (!sidebarOpen) {
    sidebar.classList.add('sidebar-responsive');
    sidebarOpen = true;
  }
}

function closeSidebar() {
  if (sidebarOpen) {
    sidebar.classList.remove('sidebar-responsive');
    sidebarOpen = false;
  }
}

// ---------- CHARTS ----------
const radarCtx = document.getElementById('radarChart').getContext('2d');
const radarChart = new Chart(radarCtx, {
    type: 'radar',
    data: {
        labels: ['Recyclable', 'Non-recyclable', 'Hazardous'], // Waste types
        datasets: [{
            label: 'Area 1',
            data: [65, 59, 90], // Replace with actual data for Area 1
            backgroundColor: 'rgba(255, 99, 132, 0.2)',
            borderColor: 'rgba(255, 99, 132, 1)',
            borderWidth: 1
        }, {
            label: 'Area 2',
            data: [28, 48, 40], // Replace with actual data for Area 2
            backgroundColor: 'rgba(54, 162, 235, 0.2)',
            borderColor: 'rgba(54, 162, 235, 1)',
            borderWidth: 1
        }]
    },
    options: {
        scales: {
            r: {
                beginAtZero: true
            }
        }
    }
});

const doughnutCtx = document.getElementById('doughnutChart').getContext('2d');
const doughnutChart = new Chart(doughnutCtx, {
    type: 'doughnut',
    data: {
        labels: ['Recyclable', 'Non-recyclable', 'Hazardous'], // Waste types
        datasets: [{
            label: 'Waste Types',
            data: [40, 35, 25], // Replace with actual data
            backgroundColor: [
                'rgba(255, 99, 132, 0.2)',
                'rgba(54, 162, 235, 0.2)',
                'rgba(75, 192, 192, 0.2)'
            ],
            borderColor: [
                'rgba(255, 99, 132, 1)',
                'rgba(54, 162, 235, 1)',
                'rgba(75, 192, 192, 1)'
            ],
            borderWidth: 1
        }]
    }
});
         
function showPage(pageId) {
  // Hide all pages
  const pages = document.querySelectorAll('.page');
  pages.forEach(page => page.classList.remove('active'));

  // Show the selected page
  const selectedPage = document.getElementById(pageId);
  selectedPage.classList.add('active');
}





// Get references to the DOM elements
const fileInput = document.getElementById('fileInput');
const profileImage = document.getElementById('profileImage');
const profileIcon = document.getElementById('profileIcon');
const uploadBtn = document.getElementById('uploadBtn');
const removeBtn = document.getElementById('removeBtn');

// Event listener for the upload button
uploadBtn.addEventListener('click', () => {
    fileInput.click(); // Trigger the file input click
});

// Event listener for file input change
fileInput.addEventListener('change', (event) => {
    const file = event.target.files[0];
    if (file) {
        const reader = new FileReader();
        reader.onload = function(e) {
            profileImage.src = e.target.result; // Set the profile image to the selected file
            profileImage.style.display = 'block'; // Ensure the profile image is visible
            profileIcon.style.display = 'none'; // Hide the icon
            removeBtn.style.display = 'inline-block'; // Show the remove button
            uploadBtn.textContent = 'Change Profile'; // Change button text to 'Change Profile'
        };
        reader.readAsDataURL(file); // Read the file as a data URL
    }
});

// Event listener for the remove button
removeBtn.addEventListener('click', () => {
    profileImage.src = ''; // Clear the profile image
    profileImage.style.display = 'none'; // Hide the profile image
    profileIcon.style.display = 'flex'; // Show the icon
    fileInput.value = ''; // Clear the file input value
    removeBtn.style.display = 'none'; // Hide the remove button
    uploadBtn.textContent = 'Upload Profile'; // Change button text back to 'Upload Profile'
});


document.getElementById('profile-form').addEventListener('submit', function(event) {
  event.preventDefault(); // Prevent the form from submitting the traditional way

  const fullname = document.getElementById('fullname').value;
  const username = document.getElementById('username').value;
  const email = document.getElementById('email').value;
  const phone = document.getElementById('phone').value;
  const bio = document.getElementById('bio').value;

  // Simple validation (for demonstration purposes)
  if (fullname && username && email && phone) {
      document.getElementById('message').textContent = 'Profile updated successfully!';
      document.getElementById('message').style.color = 'green';
  } else {
      document.getElementById('message').textContent = 'Please fill in all required fields.';
      document.getElementById('message').style.color = 'red';
  }

  // Here you would typically send the data to a server
});



