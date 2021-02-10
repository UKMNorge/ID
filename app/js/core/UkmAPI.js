class UkmAPI {
    path = 'https://id.ukm.dev/app/api/';
    constructor() {

    }

    async masterCall(method, subPath, args) {
        return new Promise((resolve, reject) =>{
            console.log('here');
            $.ajax({			
                "url": this.path + subPath,
                "method": method,
                "data": args ? args : {},
                success: (data) => {
                    console.log(data.length);
                    try {
                        resolve(JSON.parse(data));
                    } catch(e) {
                        resolve(JSON.parse('{}'));
                    }
                },
                error: (err) => {
                    reject(err);
                }
            });
        })
    }
}