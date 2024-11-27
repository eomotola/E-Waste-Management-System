

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width,initial-scale=1.0">
    <title>Admin Dashboard</title>

    <!-- Montserrat Font -->
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@100;200;300;400;500;600;700;800;900&display=swap" rel="stylesheet">

    <!-- Material Icons -->
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons+Outlined" rel="stylesheet">

    <!-- Custom CSS -->
    <link rel="stylesheet" href="dashboard.css">
</head>
<body>
<div class="grid-container">

    <!-- Header -->
    <header class="header">
        <div class="menu-icon" onclick="openSidebar()">
            <span class="material-icons-outlined">menu</span>
        </div>
        <div class="header-left">
            <p>Admin-Dashboard</p>
        </div>
        <div class="header-right">
            <img src="img/Group 30.png">
        </div>
    </header>
    <!-- End Header -->

    <!-- Sidebar -->
    <aside id="sidebar">
        <div class="sidebar-title">
            <div class="sidebar-brand">
                <img src="img/Group 25 1.png">
            </div>
            <span class="material-icons-outlined" onclick="closeSidebar()">close</span>
        </div>

        <ul class="sidebar-list">
            <li class="sidebar-list-item">
                <a href="#" onclick="showPage('dashboard')">
                    <span class="material-icons-outlined">dashboard</span> Dashboard
                </a>
            </li>
            <li class="sidebar-list-item">
                <a href="#" onclick="showPage('account')">
                    <span class="material-icons-outlined">account_circle</span> My Account
                </a>
            </li>
            <li class="sidebar-list-item">
                <a href="#" onclick="showPage('polls')">
                    <span class="material-icons-outlined">payments</span> Waste Status
                </a>
            </li>
            <li class="sidebar-list-item">
                <a href="#" onclick="showPage('settings')">
                    <span class="material-icons-outlined">settings</span> Settings
                </a>
            </li>
        </ul>

        <div class="logout-container">
            <a href="index.html" class="logout-button">Logout</a>
        </div>
    </aside>
    <!-- End Sidebar -->

    <main class="main-container">

        <!-- DASHBOARD Page -->
        <div id="dashboard" class="page active">
            <div class="main-title">
                <p class="font-weight-bold">DASHBOARD</p>
            </div>
    
            <div class="main-cards">
                <div class="charts active">
                    <div class="charts-card">
                        <p class="chart-title">Waste Collection Analysis</p>
                    <div class="chart-container">
                        <canvas id="radarChart"></canvas>
                    </div>
                    </div>
    
                    <div class="charts-card">
                        <p class="chart-title">Total Number of Waste Collected</p>
                        <h3 class="chart-text">120</h3>
                      
                    </div>
                
    
                    <div class="charts-card">
                        <p class="chart-title">Waste Analysis</p>
                    <div class="chart-container">
                        <canvas id="doughnutChart"></canvas>
                    </div>
                     </div>
    
                    <div class="charts-card">
                        <div class="box">
                            <p class="chart-title">Admin Details</p>
                            <img src="img/Group 31.png">
                            <h4>Full Name</h4>
                            <p>Lagos State University, Ojo</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    
        <!-- ACCOUNT Page -->
        <div id="account" class="page">
            <div class="main-title">
                <p class="font-weight-bold">MY ACCOUNT</p>
            </div>
            <div class="account-content">
                <div class="profile">
                    <img src="img/Group 11.png">
                    <div class="account-details">
                        <h3>John Doe</h3>
                        <h4>Administrator</h4>
                        <p>An admin in an electricity payment system oversees user management by handling account creation, updates, and permissions. 
                        They ensure smooth system operation through routine maintenance and performance monitoring. 
                        The admin manages and reviews payment transactions to ensure accuracy and addresses any issues.
                        They also generate and analyze reports on system performance and user activity, maintain robust security measures to protect sensitive data, 
                        and provide technical support to resolve user queries and problems efficiently.</p>
                    </div>
                </div>
            </div>
        </div>
    
        <div id="polls" class="page">
            <div class="main-title">
                <p class="font-weight-bold">WASTE DETAILS</p>
            </div>
            

            
        </div>
        


        <!-- SETTINGS Page -->
        <div id="settings" class="page">
            <div class="main-title">
                <p class="font-weight-bold">SETTINGS</p>
            </div>

            <div class="setting-content">
                <ul class="setting-nav">
                    <a href="#">
                        <li>Account Settings - Update Profile</li>
                    </a>
                </ul>

                <div id="profile-container" class="profile-container">
                    <div class="image-wrapper">
                        <img id="profileImage" src="images/account_circle_24dp_E8EAED_FILL0_wght400_GRAD0_opsz24.png" alt="Profile Picture" />
                        <img id="profileIcon" src="images/account_circle_24dp_E8EAED_FILL0_wght400_GRAD0_opsz24.png" alt="Profile Picture" style="display: none;" />
                    </div>
                    <input type="file" id="fileInput" accept="image/*" style="display: none;" />
                    <button id="uploadBtn" class="btn">Upload Profile</button>
                    <button id="removeBtn" class="btn" style="display: none;">Remove Profile</button>
                </div>

                <div class="submit-btn">
                        <a href="updateprofile.php">Update Profile</a>
                </div>
            

                <div id="message"></div>

            </div>    
        </div>
    </main>
</div>

<!-- Scripts -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/progressbar.js/1.1.0/progressbar.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script src="dashboard.js"></script>

</body>
</html>

