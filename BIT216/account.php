<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Account page</title>
    <link rel="stylesheet" href="css/accountstyle.css">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Jua&display=swap">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <script src="https://kit.fontawesome.com/bbf63d7a1f.js" crossorigin="anonymous"></script>
</head>
<body>
    <div class="container1">
        <aside class="sidebar">
            <div class="logo">
                <img src="image/GOGREEN1.png" alt="Logo">
            </div>
            <?php
                include 'nav.php';
            ?>
        </aside>
        <main class="main-content">
            <header class="header">
                <div class="welcome-message">
                    <h1>My Account</h1>
                    <p>Welcome to GoGreen</p>
                </div>
                <div class="user-profile">
                    <button class="noti">
                        <i class="fa-solid fa-bell"></i>
                        <div class="noti-num">3</div>
                    </button>
                    <img src="image/handsome.jpeg" alt="Profile Picture">
                    <p>Hello Nigg4</p>
                </div>
            </header>

            <section class="content">
                <div class="container">
                    <div class="row row1" style="align-items:center;">
                        <div class="col-3 text-center">
                            <div class="avatar">
                                <!-- Placeholder for avatar image -->
                                <img src="image/handsome.jpeg" alt="User Avatar">
                            </div>
                        </div>
                        <div class="col-1 d-flex btn-div flex-column">
                            <button class="btn-avatar btn-change">Change</button>
                            <button class="btn-avatar btn-delete">Delete</button>
                        </div>
                        <div class="col-6"></div>
                        <div class="col-2 save-btn-div">
                            <button class="btn btn-secondary btn-save">Cancel</button>
                            <button class="btn btn-success btn-cancel">Save</button>
                        </div> 


                    </div>

                    <!-- Form fields -->
                    <div class="row mb-3">
                        <div class="col">
                            <label for="firstName">First Name</label>
                            <input type="text" class="form-control" id="firstName" placeholder="First Name">
                        </div>
                        <div class="col">
                            <label for="lastName">Last Name</label>
                            <input type="text" class="form-control" id="lastName" placeholder="Last Name">
                        </div>
                    </div>

                    <div class="row mb-3">
                        <div class="col">
                            <label for="password">Password</label>
                            <div class="input-container">
                                <input type="password" class="form-control" id="password" placeholder="Password">
                                <button class="edit-button">
                                    <i class="fa-solid fa-pen"></i>
                                </button>
                            </div>
                        </div>
                    </div>

                    <div class="row mb-3">
                        <div class="col">
                            <label for="email">Email</label>
                            <input type="email" class="form-control" id="email" placeholder="Email">
                        </div>
                        <div class="col">
                            <label for="contactNumber">Contact Number</label>
                            <input type="tel" class="form-control" id="contactNumber" placeholder="Contact Number">
                        </div>
                    </div>

                    <div class="row mb-3">
                        <div class="col">
                            <label for="address">Address</label>
                            <input type="text" class="form-control" id="address" placeholder="Address">
                        </div>
                    </div>

                    

                    <!-- Save Changes button -->
                    <div class="row">
                        
                    </div>
                </div>
                <!-- <div class="profile-card">
                    <div class="profile-picture">
                        <img src="image/handsome.jpeg" alt="Profile Picture">
                    </div>
                    <h2>My profile</h2>
                    <p class = "new-container">  
                        <span class="bold-text">Nigg4</span> 
                        <span class="community">Embayu Damansara West</span>
                    </p>
                    <p>010-000 0000</p>
                    <p>GoGreen@gmail.com</p>

                    <p>C-xx-xx, Embayu Damansara West, Persiaran Kosmos, Taman Subang Mrni, 40150 Shah Slam, Selangor.</p>

                </div>
                <div class="account-bill-container">
                    <div class="accounts">
                        <h2>My xPay accounts</h2>
                        <div class="account">
                            <p>Active account</p>
                            <p>8040 5060 8098 4525</p>
                            <button class="block-btn">Block Account</button>
                        </div>
                        <div class="account">
                            <p>Blocked account</p>
                            <p>7162 5088 3134 3148</p>
                            <button class="unblock-btn">Unblock account</button>
                        </div>
                    </div>
                    <div class="bills">
                        <h2>My bills</h2>
                        <div class="bill">
                            <p>Phone bill</p>
                            <span class="status paid">Bill paid</span>
                        </div>
                        <div class="bill">
                            <p>Internet bill</p>
                            <span class="status unpaid">Not paid</span>
                        </div>
                        <div class="bill">
                            <p>House rent</p>
                            <span class="status paid">Bill paid</span>
                        </div>
                        <div class="bill">
                            <p>Income tax</p>
                            <span class="status paid">Bill paid</span>
                        </div>
                    </div>
                </div> -->
            </section>
        </main>
    </div>
</body>
</html>
