export default {
    methods: {
        getDateTime() {
            let today = new Date();
            let dd = String(today.getDate()).padStart(2, '0');
            let mm = String(today.getMonth() + 1).padStart(2, '0'); 
            let yyyy = today.getFullYear();
            let h = today.getHours();
            let m = today.getMinutes();
            let s = today.getSeconds();

            return dd + '-' + mm + '-' + yyyy + " " + h + ":" + m + ":" + s;
        }
    }
}
