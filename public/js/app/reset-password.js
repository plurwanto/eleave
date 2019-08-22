var app = new Vue({
    el: '#reset-password-form',
    data:{
        showError: false,
        showSuccess: false,
        btnDisabled: false,
        errorMsg: '',
        successMsg: '',
        textBtnReset: 'Change My Password',
        resetPassInput: {
                            password: '',
                            retypePassword: '',
                            token: document.getElementById('reset_token').value
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

                axios.post(apiUrl+'reset-password', this.resetPassInput)
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
                            this.textBtnReset   = 'Change My Password'
                        }
                        else
                        {
                            this.btnDisabled    = false
                            this.showError      = false
                            this.showSuccess    = true
                            this.successMsg     = 'Success! \n Please login with your new password'

                            this.textBtnReset = 'Redirecting...'

                            setTimeout(function(){location.href = webUrl+'login'},3000)
                        }
                    })
                    .catch((error) =>
                    {
                        this.showSuccess    = false
                        this.btnDisabled    = false
                        this.showError      = true
                        this.errorMsg       = 'Failed, Please contact your Administrator'
                        this.textBtnReset   = 'Change My Password'
                    })
            }
        },

        validateResetPass()
        {
            if(app.resetPassInput.password.length <= 0)
            {
                this.showSuccess    = false
                this.showError      = true
                this.errorMsg       = 'Please input your new password'

                return false
            }

            if(app.resetPassInput.retypePassword.length <= 0)
            {
                this.showSuccess    = false
                this.showError      = true
                this.errorMsg       = 'Please re-type your new password'

                return false
            }

            if(app.resetPassInput.password != app.resetPassInput.retypePassword)
            {
                this.showSuccess    = false
                this.showError      = true
                this.errorMsg       = 'The password did not match'

                return false
            }

            var regExp = /(?=.*\d)(?=.*[a-z])(?=.*[0-9]).{6,}/;
             
            var validPassword = regExp.test(app.resetPassInput.password);

            if(!validPassword)
            {
                this.showSuccess    = false
                this.showError      = true
                this.errorMsg       = 'The password should contain lowercase, number, and not less than 6 character'

                return false
            }

            return true
        }
    }
})