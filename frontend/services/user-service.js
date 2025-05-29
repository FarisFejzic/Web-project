var UserService = {
  init: function () {
    UserService.generateMenuItems();
    $("#loginForm").validate({
        
      submitHandler: function (form) {
        var entity = Object.fromEntries(new FormData(form).entries());
        UserService.login(entity);
      },
    });
    $("#registerForm").validate({ 
        rules: {
            first_name: 'required',
            last_name: 'required',
            email:{
                required: true,
                email: true
            },
            password: {
                required: true,
                minlength: 6,
                containsNumber: true
            },
            confirm_password: {
                required: true,
                equalTo: "#registerPassword"
            }

        }, 
        messages: {
            first_name: "First name is required",
            last_name: "Last name is required",
            email: {
                required: "Email is required",
                email: "Please enter a valid email address"
            },
            password: {
                required: "Password is required",
                minlength: "Password must be at least 6 characters long",
                containsNumber: "Password must contain at least one number"
            },
            confirm_password: {
                required: "Please confirm your password",
                equalTo: "Passwords do not match"
            }
        },
      submitHandler: function (form) {
        var entity = Object.fromEntries(new FormData(form).entries());
        UserService.register(entity);
      },
    }); 
  },
  login: function (entity) {
    $.ajax({
      url: Constants.PROJECT_BASE_URL + "auth/login",
      type: "POST",
      data: JSON.stringify(entity),
      contentType: "application/json",
      dataType: "json",
      success: function (result) {
        console.log(result);
        localStorage.setItem("user_token", result.data.token);
        UserService.generateMenuItems();
      },
      error: function (XMLHttpRequest, textStatus, errorThrown) {
        toastr.error(XMLHttpRequest?.responseText ?  XMLHttpRequest.responseText : 'Error');
      },
    });
  },
  register: function (entity) {
    $.ajax({
      url: Constants.PROJECT_BASE_URL + "auth/register",
      type: "POST",
      data: JSON.stringify(entity),
      contentType: "application/json",
      dataType: "json",
      success: function (result) {
        console.log(result);
        localStorage.setItem("user_token", result.data.token);
        UserService.generateMenuItems();
        toastr.success("Registration successful. You are now logged in.");
      },
      error: function (XMLHttpRequest, textStatus, errorThrown) {
        toastr.error(XMLHttpRequest?.responseText ?  XMLHttpRequest.responseText : 'Error');
      },
    });
  },

  logout: function () {
    localStorage.clear();
    UserService.generateMenuItems();
    toastr.info("You have been logged out.");
    window.scrollTo({ top: 0, behavior: "smooth" });
  },

  generateMenuItems: function() {
    const token = localStorage.getItem("user_token");
    let user = null;
    
    // Only try to parse if token exists
    if (token) {
        try {
            const parsedToken = Utils.parseJwt(token);
            user = parsedToken ? parsedToken.user : null;
        } catch (e) {
            console.error("Error parsing token:", e);
            // Handle invalid token (optional: clear it)
            localStorage.removeItem("user_token");
        }
    }

    let nav = "";
    let main = "";

    if (user && user.role) {
        switch(user.role) {
            case Constants.USER_ROLE:
                nav = '<a href="#about" class="nav-item nav-link">About</a>'+
                      '<a href="#package" class="nav-item nav-link">Packages</a>'+
                      '<a href="#" class="nav-item nav-link" onClick="logout()">Log out</a>';
                $("#navBar").html(nav);

                main = '<section id="404"></section>'+
                       '<section id="package"></section>'+
                       '<section id="viewmore"></section>'+
                       '<section id="about" data-load="about.html"></section>';
                $("#spapp").html(main);
                break;
            case Constants.ADMIN_ROLE:
                nav = '<a href="#about" class="nav-item nav-link">About</a>'+
                      '<a href="#package" class="nav-item nav-link">Packages</a>'+
                      '<a href="#adminpanel" class="nav-item nav-link">Admin Panel</a>'+
                      '<a href="#" class="nav-item nav-link" onClick="logout()">Log out</a>';
                $("#navBar").html(nav);

                main = '<section id="adminpanel"></section>'+
                       '<section id="404"></section>'+
                       '<section id="package"></section>'+
                       '<section id="viewmore"></section>'+
                       '<section id="about" data-load="about.html"></section>';
                $("#spapp").html(main);
                break;
            default:
                toastr.error("Invalid role detected. You have been logged out.");
                UserService.logout();
                return;
        }
    } else {
        nav = '<a href="#about" class="nav-item nav-link">About</a>' +
              '<a href="#package" class="nav-item nav-link">Packages</a>' +
              '<a href="#" class="nav-item nav-link" data-bs-toggle="modal" data-bs-target="#registerModal">Register</a>';
        $("#navBar").html(nav);
        
        main = '<section id="404"></section>' +
               '<section id="package"></section>' +
               '<section id="viewmore"></section>' +
               '<section id="about" data-load="about.html"></section>';
        $("#spapp").html(main);
    }
}
};