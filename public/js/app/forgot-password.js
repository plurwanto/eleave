var app = new Vue({
    el: '#forgot-password-form',
    data:{
        showError: false,
        showSuccess: false,
        btnDisabled: false,
        errorMsg: '',
        successMsg: '',
        textBtnReset: 'Reset My Password',
        forgotPassInput: {
                            email: ''
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

                axios.post(apiUrl+'forgot-password', this.forgotPassInput)
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
                            this.textBtnReset   = 'Reset My Password'
                        }
                        else
                        {
                            this.btnDisabled    = false
                            this.showError      = false
                            this.showSuccess    = true
                            this.successMsg     = 'Success!\nPlease check your email'

                            this.textBtnReset = 'Redirecting...'

                            var param = {
                                            'to'        : response.data.data.email,
                                            'data'      :   {
                                                                'name'      : response.data.data.user_name,
                                                                'urlReset'  : `${webUrl}reset-password/${response.data.data.token}`
                                                            },
                                            'file_name' : `resetPassword`,
                                            'from'      : `notification@elabram.com`,
                                            'from_name' : `notification@elabram.com`,
                                            'bcc'       : `kenji.a@elabram.com`,
                                            // 'bcc'       : `kartaterazu27@gmail.com`,
                                            'subject'   : `Forgot Password`
                                        }

                            setMail(param)

                            setTimeout(function(){location.href = webUrl+'login'},3000)
                        }
                    })
                    .catch((error) =>
                    {
                        this.showSuccess    = false
                        this.btnDisabled    = false
                        this.showError      = true
                        this.errorMsg       = 'Failed, Please contact your Administrator'
                        this.textBtnReset   = 'Reset My Password'
                    })
            }
        },

        validateResetPass()
        {
            if(app.forgotPassInput.email.length <= 0)
            {
                this.showSuccess    = false
                this.showError      = true
                this.errorMsg       = 'Please input your email'

                return false
            }

            return true
        }
    }
})