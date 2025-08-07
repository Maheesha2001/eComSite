
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Account</title>
    <!-- Font Awesome CDN for icons -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Custom style.css -->
    <link rel="stylesheet" href="../style.css">
    <style>
        .theme-green { color: #43a047 !important; }
        .btn-theme-green { background-color: #43a047 !important; border-color: #43a047 !important; color: #fff !important; }
        .btn-theme-green:hover { background-color: #388e3c !important; border-color: #388e3c !important; }
        a.theme-green-link { color: #43a047 !important; }
        a.theme-green-link:hover { color: #2e7031 !important; }
        
        .profile-image-preview {
            width: 150px;
            height: 150px;
            object-fit: cover;
            border-radius: 50%;
            border: 4px solid #fff;
            box-shadow: 0 2px 10px rgba(0,0,0,0.1);
        }
        
        .edit-form-card {
            background: #fff;
            border-radius: 10px;
            box-shadow: 0 2px 15px rgba(0,0,0,0.1);
        }
    </style>
</head>
<body style="background-color: #f8f9fa;">
  

    <div class="container mt-4">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card edit-form-card">
                    <div class="card-header bg-primary text-white">
                        <h4 class="mb-0">
                            <i class="fas fa-user-edit me-2"></i>Edit Account
                        </h4>
                    </div>
                    <div class="card-body p-4">
                        <?php
                        if(isset($_SESSION['username'])) {
                            $username = $_SESSION['username'];
                            $get_user = "SELECT * FROM user_table WHERE user_name='$username'";
                            $result_user = mysqli_query($conn, $get_user);
                            
                            if($result_user && mysqli_num_rows($result_user) > 0) {
                                $user_data = mysqli_fetch_array($result_user);
                                
                                // Handle form submission
                                if(isset($_POST['update_account'])) {
                                    $new_username = trim($_POST['username']);
                                    $new_email = trim($_POST['email']);
                                    $new_address = trim($_POST['address']);
                                    $new_phone = trim($_POST['phone']);
                                    $user_id = $user_data['user_id'];
                                    
                                    // Handle image upload
                                    $new_image = $user_data['user_image']; // Keep existing image by default
                                    if(isset($_FILES['user_image']) && $_FILES['user_image']['error'] == 0) {
                                        $allowed_types = ['image/jpeg', 'image/jpg', 'image/png', 'image/gif'];
                                        if(in_array($_FILES['user_image']['type'], $allowed_types)) {
                                            $upload_dir = "user_images/";
                                            $file_extension = pathinfo($_FILES['user_image']['name'], PATHINFO_EXTENSION);
                                            $new_image = "user_" . $user_id . "_" . time() . "." . $file_extension;
                                            $upload_path = $upload_dir . $new_image;
                                            
                                            if(move_uploaded_file($_FILES['user_image']['tmp_name'], $upload_path)) {
                                                // Delete old image if it exists and is different
                                                if($user_data['user_image'] && $user_data['user_image'] != $new_image) {
                                                    $old_image_path = $upload_dir . $user_data['user_image'];
                                                    if(file_exists($old_image_path)) {
                                                        unlink($old_image_path);
                                                    }
                                                }
                                            }
                                        }
                                    }
                                    
                                    // Update user data
                                    $update_query = "UPDATE user_table SET user_name=?, user_email=?, user_image=?, user_address=?, user_mobile=? WHERE user_id=?";
                                    $stmt = mysqli_prepare($conn, $update_query);
                                    mysqli_stmt_bind_param($stmt, "sssssi", $new_username, $new_email, $new_image, $new_address, $new_phone, $user_id);
                                    
                                    if(mysqli_stmt_execute($stmt)) {
                                        // Update session username if changed
                                        if($new_username != $username) {
                                            $_SESSION['username'] = $new_username;
                                        }
                                        echo "<div class='alert alert-success text-center'>
                                                <i class='fas fa-check-circle me-2'></i>
                                                Account updated successfully!
                                              </div>
                                              <script>
                                                setTimeout(function() {
                                                    window.location.href = 'profile.php?edit_account&updated=1';
                                                }, 1500);
                                              </script>";
                                        // Refresh user data
                                        $result_user = mysqli_query($conn, $get_user);
                                        $user_data = mysqli_fetch_array($result_user);
                                    } else {
                                        echo "<div class='alert alert-danger text-center'>
                                                <i class='fas fa-exclamation-triangle me-2'></i>
                                                Failed to update account. Please try again.
                                              </div>";
                                    }
                                }
                                ?>
                                
                                <form action="" method="post" enctype="multipart/form-data">
                                    <div class="row">
                                        <!-- Profile Image Section -->
                                        <div class="col-md-4 text-center mb-4">
                                            <div class="mb-3">
                                                <img src="user_images/<?php echo $user_data['user_image']; ?>" 
                                                     alt="Profile Picture" 
                                                     class="profile-image-preview"
                                                     id="imagePreview">
                                            </div>
                                            <div class="mb-3">
                                                <label for="user_image" class="form-label">Update Profile Picture</label>
                                                <input type="file" class="form-control" id="user_image" name="user_image" accept="image/*" onchange="previewImage(this)">
                                                <small class="text-muted">JPG, PNG, GIF up to 5MB</small>
                                            </div>
                                        </div>
                                        
                                        <!-- Form Fields -->
                                        <div class="col-md-8">
                                            <div class="row">
                                                <div class="col-md-6 mb-3">
                                                    <label for="username" class="form-label">Username</label>
                                                    <input type="text" class="form-control" id="username" name="username" 
                                                           value="<?php echo htmlspecialchars($user_data['user_name']); ?>" required>
                                                </div>
                                                <div class="col-md-6 mb-3">
                                                    <label for="email" class="form-label">Email</label>
                                                    <input type="email" class="form-control" id="email" name="email" 
                                                           value="<?php echo htmlspecialchars($user_data['user_email']); ?>" required>
                                                </div>
                                                <div class="col-12 mb-3">
                                                    <label for="address" class="form-label">Address</label>
                                                    <textarea class="form-control" id="address" name="address" rows="3" required><?php echo htmlspecialchars($user_data['user_address']); ?></textarea>
                                                </div>
                                                <div class="col-md-6 mb-3">
                                                    <label for="phone" class="form-label">Phone Number</label>
                                                    <input type="tel" class="form-control" id="phone" name="phone" 
                                                           value="<?php echo htmlspecialchars($user_data['user_mobile']); ?>" required>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    
                                    <!-- Action Buttons -->
                                    <div class="row mt-4">
                                        <div class="col-12 text-center">
                                            <button type="submit" class="btn btn-theme-green btn-lg me-3" name="update_account">
                                                <i class="fas fa-save me-2"></i>Update Account
                                            </button>
                                            <a href="profile.php" class="btn btn-outline-secondary btn-lg">
                                                <i class="fas fa-arrow-left me-2"></i>Back to Profile
                                            </a>
                                        </div>
                                    </div>
                                </form>
                                <?php
                            } else {
                                echo "<div class='alert alert-warning text-center'>
                                        <i class='fas fa-exclamation-triangle me-2'></i>
                                        User not found
                                      </div>";
                            }
                        } else {
                            echo "<div class='alert alert-warning text-center'>
                                    <i class='fas fa-exclamation-triangle me-2'></i>
                                    Please login to edit your account
                                  </div>";
                        }
                        ?>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        function previewImage(input) {
            if (input.files && input.files[0]) {
                var reader = new FileReader();
                reader.onload = function(e) {
                    document.getElementById('imagePreview').src = e.target.result;
                };
                reader.readAsDataURL(input.files[0]);
            }
        }
    </script>
</body>
</html>