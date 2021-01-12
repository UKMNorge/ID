class CodeForward {
    destroyed = false;
    intervalTime = 500;
    interval;

    constructor() {

    }
    
    async waitingForAnswer() {
        return new Promise((resolve, reject) => {
            this.interval = setInterval( ()=> {
                var data = await ukmAPI.masterCall(
                    'POST', 
                    'register-new-user.php', 
                    {
                        "tel_nr": $('#loginTelNr').val()
                    }
                );
                
                if(this.destroyed) {
                    clearInterval(this.interval);
                    this.destroyed = true;
                    reject();
                }

                if(data.result == true) {
                    clearInterval(this.interval);
                    this.destroyed = true;
                    resolve(data);
                }
    
            }, this.intervalTime);
        })
    }

    destroy() {
        this.destroyed = true;
    }
    
}