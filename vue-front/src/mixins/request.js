import en from '../lang/en'
import urdu from '../lang/urdu'
export const request = 
{
    mixins:[en,urdu,],
    
    data() {
        return {
            lang:"en",
        }
    },


    methods: 
    {
        loadJS(scripts) {
            scripts.forEach((script) => {
              // if(!this.isScriptAlreadyIncluded(script,'script','src')){//check script alread load or not
                let tag = document.createElement("script");
                tag.setAttribute('type','text/javascript');
                tag.setAttribute("src", script);
                tag.async = true;
                document.body.appendChild(tag);
              // }
            });
        },

        translate(prop){
            const lang  =  localStorage.getItem('lang') || this.lang
            return this[lang][prop];
        },

        filterNumbers(event) {
            const input = event.target;
            const filteredValue = input.value.replace(/\D/g, ''); // Remove non-numeric characters
            input.value = filteredValue; // Update the input value
            this.v$.form.phone.$model = filteredValue; // Update the v-model value if necessary
        },


    },

    
};
