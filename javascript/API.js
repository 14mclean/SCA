export default class API {
    static API_METHOD_GET = 1;
    static API_METHOD_PATCH = 1;
    static API_METHOD_POST = 1;
    static API_METHOD_DELETE = 1;
    static #url = "schoolcitizenassemblies/api/";
    static #methods = {
        API_METHOD_GET:"GET",
        API_METHOD_PATCH:"PATCH",
        API_METHOD_POST:"POST",
        API_METHOD_DELETE:"DELETE"
    }

    static api_request(path, method, body_data = null) {
        path = this.#url + path;

        switch(method){
            case(this.API_METHOD_GET):
                return this.#get_requset(path);
            case(this.API_METHOD_POST):
                return this.#post_request(path);
            case(this.API_METHOD_PATCH):
                return this.#patch_request(path);
            case(this.API_METHOD_DELETE):
                return this.#delete_request(path);
        }

    }

    static #get_request(path) {
        fetch(path)
        .then((response) => {
            if(response.ok) {
              return response.json();
            } else {
              throw new Error('Server error ' + response.status);
            }
        })
    }

    static #delete_request(path) {
        fetch(
            path,
            {method: "DELETE"}
        )
        .then((response) => {
            if(response.ok) {
              return response.json();
            } else {
              throw new Error('Server error ' + response.status);
            }
        })
    }

    static #post_request(path, body_data) {
        fetch(path, {
            method: "POST",
            headers: {'Content-Type': 'application/json'},
            body: body_data
        })
        .then((response) => {
            if(response.ok) {
              return response.json();
            } else {
              throw new Error('Server error ' + response.status);
            }
        });
    }

    static #patch_request(path, body_data) {
        fetch(path, {
            method: "PATCH",
            headers: {'Content-Type': 'application/json'},
            body: body_data
        })
        .then((response) => {
            if(response.ok) {
              return response.json();
            } else {
              throw new Error('Server error ' + response.status);
            }
        });
    }
}