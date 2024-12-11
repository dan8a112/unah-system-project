export const LOGIN_KEYS = {
    'APA': {
        apiUrl: "../../../api/post/login/loginAdmission/",
        redirectUrl: "../admission/administrative_home.php"
    },
    'SEDP': {
        apiUrl: "../../../api/post/login/loginSEDP/",
        redirectUrl: "../administration/sedp-portal.php"
    },
    'PROFESSORS':{
        apiUrl: "../../../api/post/login/loginProfessor/",
        redirectUrl: "../professors/home_professors.php"
    },
    'CRI':{
        apiUrl: "../../../api/post/login/loginCRI/",
        redirectUrl: "../admission/cri_portal.php"
    },
    'BOSSES':{
        apiUrl: "../../../api/post/login/loginDepartmentBoss/",
        redirectUrl: "../administration/bosses/administrate_sections.php"
    },
    'COORDINATORS':{
        apiUrl: "../../../api/post/login/loginCoordinator/",
        redirectUrl: "../administration/coordinators/academic_load.php"
    },
    'STUDENTS':{
        apiUrl: "../../../api/post/login/loginStudent/",
        redirectUrl: "../students/academic_historic.php"
    }
}