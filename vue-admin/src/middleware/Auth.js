
export default (to, from, next) => 
{   
    var auth = (localStorage.getItem('admin_info') && localStorage.getItem('admin_info') !='')?true: false;

        if( auth === true)
        { 
            next();
        }
        else
        {   
            window.location.href = 'http://localhost:8080/';
        }

};
