class OnePage {

    constructor() {
        this.pageId;

        this._events();
        this._changeState();
    }

    _changeState(pageId, pushState = true) {
        var pageId = pageId ? pageId :  this.getArgument('pageId');
        // alert(pageId);
        this.render((pageId ? pageId : 0), pushState);
        console.log(this);
    }

    // Add argument to url
    addArgument(key, value, pushState) {
        var urlHref = window.location.href
        var url = new URL(urlHref);
        var params = new URLSearchParams(url.search);
        
        params.set(key, value);

        console.warn(pushState);

        if(pushState) {
            window.history.pushState({
                path: '',
                hash: ''
              }, '',
               '/' + '?' + params);
        }
        else {
            window.history.replaceState({
              path: '',
              hash: ''
            }, '',
             '/' + '?' + params);
        }
    }
    
    // Get argument from url
    getArgument(arg) {
        var urlHref = window.location.href
        var url = new URL(urlHref);
        var val = url.searchParams.get(arg);
        return val != null && val.length > 0 ? val : null;
    }

    // Remove argument from url
    removeArgument() {

    }

    // Render the page based on argument
    render(pageId, pushState = true) {
        this.pageId = pageId;

        this._hideAllPages();
        this._showPage(this.pageId);
        this.addArgument('pageId', pageId, pushState);
    }

    // Hide page with id
    _hideAllPages() {
        $('.one-page-page').hide();
    }

    // Show page with id
    _showPage(id) {
        $(`.one-page-page[page-id=${id}]`).show();
    }

    _events() {
        window.onpopstate = (event) => {
            this._changeState(null, false);
        }
    }
}