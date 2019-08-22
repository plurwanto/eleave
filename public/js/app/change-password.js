var app = new Vue({
    el: '#change-password-form',
    data:{
        showError: false,
        showSuccess: false,
        btnDisabled: false,
        errorMsg: '',
        successMsg: '',
        textBtnReset: 'Submit',
        changePassInput: {
                            oldPassword: '',
                            password: '',
                            retypePassword: ''
        }
    },
 
    methods:{
        checkEmail()
        {
            if(app.validateResetPass())
            {
                this.textBtnReset   = 'Checking Your Credential...'
                this.showSuccess    = false
                this.showError      = false
                this.btnDisabled    = true

                this.changePassInput.token = token

                axios.post(apiUrl+'change-password', this.changePassInput)
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
                            this.textBtnReset   = 'Submit'
                        }
                        else
                        {
                            this.btnDisabled    = false
                            this.showError      = false
                            this.showSuccess    = true
                            this.successMsg     = response.data.message

                            this.textBtnReset = 'Redirecting...'

                            setTimeout(function(){location.href = webUrl+'index'},3000)
                        }
                    })
                    .catch((error) =>
                    {
                        this.showSuccess    = false
                        this.btnDisabled    = false
                        this.showError      = true
                        this.errorMsg       = 'Failed, Please contact your Administrator'
                        this.textBtnReset   = 'Submit'
                    })
            }
        },

        validateResetPass()
        {
            if(app.changePassInput.oldPassword.length <= 0)
            {
                this.showSuccess    = false
                this.showError      = true
                this.errorMsg       = 'Please input your old password'

                return false
            }

            if(app.changePassInput.password.length <= 0)
            {
                this.showSuccess    = false
                this.showError      = true
                this.errorMsg       = 'Please input your new password'

                return false
            }

            if(app.changePassInput.retypePassword.length <= 0)
            {
                this.showSuccess    = false
                this.showError      = true
                this.errorMsg       = 'Please re-type your new password'

                return false
            }

            if(app.changePassInput.password != app.changePassInput.retypePassword)
            {
                this.showSuccess    = false
                this.showError      = true
                this.errorMsg       = 'The password did not match'

                return false
            }

            var regExp = /(?=.*\d)(?=.*[a-z])(?=.*[0-9]).{6,}/;
             
            var validPassword = regExp.test(app.changePassInput.password);

            if(!validPassword)
            {
                this.showSuccess    = false
                this.showError      = true
                this.errorMsg       = 'The password must be at least 6 characters. It must contain at least number(0-9), lower case letters (a-z)'

                return false
            }

            return true
        },

        showHidePassword()
        {
        	
        }
    }
})
