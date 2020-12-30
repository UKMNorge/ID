class OnePage {

    constructor() {
        this.pageId;
        this.render(0)
    }

    // Add argument to url
    addArgument() {

    }
    
    // Get argument from url
    getArgument() {

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