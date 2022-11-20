class TinyMceWidget {

    constructor({options, widgetId}) {
        this.widgetId = widgetId;
        this.options = options;
    }

    init() {
        tinymce.init(this.options); 
    }
}