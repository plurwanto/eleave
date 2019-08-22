var app = new Vue({
    el: '#recruitment-app',
    data:{
        url     : recruitmentUrl,
        token     : document.getElementById('token').value || '',
        id_eleave     : document.getElementById('id_eleave').value || '',
        id_hris     : document.getElementById('id_hris').value || '',
        email     : document.getElementById('email').value || '',
        name     : document.getElementById('name').value || '',
        is_recruiter     : document.getElementById('is_recruiter').value || ''
    },
 
    methods:{
        goToInternal()
        {
            var urlDirect = `${recruitmentUrl}/getSession/${this.token}/${this.is_recruiter}`

            location.href = urlDirect

            let param = {}

            param.token = this.token
            param.id_eleave = this.id_eleave
            param.id_hris = this.is_recruiter
            param.email = this.email
            param.name = this.name
        }
    }
})