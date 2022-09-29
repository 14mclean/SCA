class PostForm extends XMLHttpRequest {
    constructor() {
        super();
        this.form = new FormData();
    }

    append(name, value,) {
        this.form.append(name, value);
    }

    send(path) {
        super.open("POST", path);
        super.send(this.form);
    }
}