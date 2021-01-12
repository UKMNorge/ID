class UkmAPI {
    path = 'https://id.ukm.dev/api/';
    constructor() {

    }

    async masterCall(method, subPath, args) {
        return new Promise((resolve, reject) =>{
            $.ajax({			
                "url": this.path + subPath,
                "method": method,
                "data": args ? args : {},
                success: (data) => {
                    resolve(JSON.parse(data ? data : '{}'));
                },
                error: (err) => {
                    reject(err);
                }
            });
        })
    }
}