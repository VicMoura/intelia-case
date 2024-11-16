import { API_PATH } from "./api";
import { get, puti, post, del } from "./api";

export default {

    list: function (args) {
      get({
        url: `${API_PATH}/address/list`,
        ...args,
      });
    },

    detail: function (id, args) {
      get({
        url: `${API_PATH}/address/${id}`,
        ...args,
      });
    },
  
    update: function (id, args) {
      puti({
        url: `${API_PATH}/address/${id}`,
        ...args,
      });
    },
  
    create: function (args) {
      post({
        url: `${API_PATH}/address`,
        ...args,
      });
    },
  
    delete: function (id, args) {
      del({
        url: `${API_PATH}/address/${id}`,
        ...args,
      });
    },
    
  };