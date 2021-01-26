class OnePage {

    constructor() {
        this.pageId;

        // var pageId = this.getArgument('pageId');
        this.render(0);
    }

    // Add argument to url
    addArgument() {

    }
    
    // Get argument from url
    getArgument(arg) {
        var urlHref = window.location.href
        var url = new URL(urlHref);
        var val = url.searchParams.get(arg);
        return val.length > 0 ? val : null;
    }

    // Remove argument from url
    removeArgument() {

    }

    // Render the page based on argument
    render(pageId) {
        this.pageId = pageId;

        this._hideAllPages();
        this._showPage(this.pageId);
    }

    // Hide page with id
    _hideAllPages() {
        $('.one-page-page').hide();
    }

    // Show page with id
    _showPage(id) {
        $(`.one-page-page[page-id=${id}]`).show();
    }
}