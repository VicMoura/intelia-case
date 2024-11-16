import { API_PATH } from "./api";
import { get, puti, post, del } from "./api";

export default {

    list: function (args) {
      get({
        url: `${API_PATH}/user/list`,
        ...args,
      });
    },

    detail: function (id, args) {
      get({
        url: `${API_PATH}/user/${id}`,
        ...args,
      });
    },
  
    update: function (id, args) {
      puti({
        url: `${API_PATH}/user/${id}`,
        ...args,
      });
    },
  
    create: function (args) {
      post({
        url: `${API_PATH}/user`,
        ...args,
      });
    },
  
    delete: function (id, args) {
      del({
        url: `${API_PATH}/user/${id}`,
        ...args,
      });
    },
    
  };