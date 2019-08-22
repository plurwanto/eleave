var app = new Vue({
    el: '#login-form',
    data:{
        showError: false,
        showSuccess: false,
        btnDisabled: false,
        errorMsg: '',
        successMsg: '',
        textBtnLogin: 'Login',
        loginInput: {
                    username: '',
                    password: ''
        }
    },
 
    methods:{
        checkLogin()
        {
            if(app.validateLogin())
            {
                this.textBtnLogin   = 'Checking Your Credential...'
                this.showSuccess    = false
                this.showError      = false
                this.btnDisabled    = true
                
                this.loginInput.login_type = 'website'

                axios.post(apiUrl+'login', this.loginInput)
                    .then((response) =>
                    {
                        // console.log(response.data)
                        // return false
                        if(response.data.error)
                        {
                            this.btnDisabled    = false
                            this.showSuccess    = false
                            this.showError      = true
                            this.errorMsg       = response.data.message
                            this.textBtnLogin   = 'Login'
                        }
                        else
                        {
                            this.btnDisabled    = true
                            this.showError      = false
                            this.showSuccess    = true
                            this.successMsg     = 'Login Success!'

                            this.textBtnLogin = 'Redirecting...'

                            //create session
                            app.createSession(response.data.data)
                        }
                    })
                    .catch((error) =>
                    {
                        this.showSuccess    = false
                        this.btnDisabled    = false
                        this.showError      = true
                        this.errorMsg       = 'Failed, Please contact your Administrator'
                        this.textBtnLogin   = 'Login'
                    })
            }
        },

        validateLogin()
        {
            if(app.loginInput.username.length <= 0)
            {
                this.showSuccess    = false
                this.showError      = true
                this.errorMsg       = 'Please input your email'

                return false
            }

            if(app.loginInput.password.length <= 0)
            {
                this.showSuccess    = false
                this.showError      = true
                this.errorMsg       = 'Please input your password'

                return false
            }

            return true
        },

        createSession(data)
        {
            axios.post(webUrl+'create-session', {'data':data})
                .then((response) =>
                {
                    if(response.data.error)
                    {
                        this.btnDisabled    = false
                        this.showSuccess    = false
                        this.showError      = true
                        this.errorMsg       = response.data.message
                        this.textBtnLogin   = 'Login'
                    }
                    else
                    {
                        this.showError      = false
                        this.showSuccess    = true
                        this.successMsg     = response.data.message

                        setTimeout(function(){location.href = webUrl+'index'},3000)
                    }
                })
                .catch((error) =>
                {
                    this.btnDisabled    = false
                    this.showSuccess    = false
                    this.showError      = true
                    this.errorMsg       = 'Failed, Please contact your Administrator'
                    this.textBtnLogin   = 'Login'

                    return false
                });
        }
    }
})