import axios from "axios";

export const API_PATH = process.env.VUE_APP_API_PATH;
export const API_PATH_IBGE = "https://servicodados.ibge.gov.br/api/v1/localidades";

function core(args) {
  axios({
    url: args.url,
    method: args.method,
    data: args.data,
    params: args.params,
  })
    .then((response) => {
      if (args.success) {
        args.success(response.data);
      }
    })
    .catch((e) => {
        if(args.error){
            args.error(e.response ? e.response.data.error : {msg : "Erro desconhecido"})
        }
    });
}

export function del(args) {
    args.method = 'delete';
    core(args);
  }
  
  export function get(args) {
    args.method = 'get';
    core(args);
  }
  
  export function post(args) {
    args.method = 'post';
    core(args);
  }
  
  export function puti(args) {
    args.method = 'put';
    core(args);
  }
