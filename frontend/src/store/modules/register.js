import UserProvider from "@/API/UserProvider";
import AddressProvider from "@/API/AddressProvider";
import PhoneProvider from "@/API/PhoneProvider";

const state = {
  user: {},
  address: {},
  phone: {
    phones: [
      {
        phone_type: "mobile",
        phone_number: "",
      },
    ],
  },
  step: 1,
};

const mutations = {

  RESET_STATE(state) {
    state.user = {};
    state.address = {};
    state.phone = {
      phones: [
        {
          phone_type: "mobile",
          phone_number: "",
        },
      ],
    };
    state.step = 1;
  },

  SET_USER(state, user) {
    state.user = user;
  },

  SET_ADDRESS(state, address) {
    state.address = address;
  },

  SET_PHONE(state, phone) {
    state.phone = phone;
  },

  SET_STEP(state, step) {
    state.step = step;
  },

};

const actions = {

  async createUser({ commit, state }) {

    let data = state.user;

    return new Promise((resolve, reject) => {
      UserProvider.create({
        data,
        success: (user) => {

          commit("SET_USER", user.user);
          localStorage.setItem("userId", user.user.id);
          resolve(user.msg);

        },
        error: (err) => {

          reject(err); 
        },
      });
    });
  },
  

  async updateUser({ commit, state }, data) {
    return new Promise((resolve, reject) => {
      UserProvider.update(state.user.id, {
        data,
        success: (user) => {

          commit("SET_USER", user.user);
          resolve(user.message);

        },
        error: (err) => {
          reject(err);
        },
      });
    });
  },
  

  async detailUser({ commit }, id) {
    await UserProvider.detail(id, {
      success: (user) => {
        
        let step = localStorage.getItem("step");

        if (step) {
          commit("SET_STEP", parseInt(step));
        }

        if (user.user) {
          commit("SET_USER", user.user);
        }

        if (user.user.address) {
          commit("SET_ADDRESS", user.user.address);
        }

        if (user.user.phone) {
          commit("SET_PHONE", user.user);
        }
      },
      error: (err) => {
        console.log("Erro ao buscar usuário", err);
      },
    });
  },

  async createAddress({ commit, state }, data) {

    data = { ...data, user_id: state.user.id };
  
    return new Promise((resolve, reject) => {
      AddressProvider.create({
        data,
        success: (address) => {

          commit("SET_ADDRESS", address.address);
          resolve("Endereço criado com sucesso.");

        },
        error: (err) => {
          reject(err);
        },
      });
    });
  },

  async updateAddress({ commit, state }, data) {
    return new Promise((resolve, reject) => {
      AddressProvider.update(state.address.id, {
        data,
        success: (address) => {

          commit("SET_ADDRESS", address.address);
          resolve("Endereço atualizado com sucesso.");
          
        },
        error: (err) => {
          reject(err);
        },
      });
    });
  },

  async createPhone({ state }, data) {

    data = { user_id: state.user.id, phones: [...data] };

    return new Promise((resolve, reject) => {
      PhoneProvider.create({
        data,
        success: () => {

          localStorage.setItem("step", 1);
          localStorage.removeItem("userId");
          resolve("Cadastro finalizado com sucesso.");
          
        },
        error: (err) => {
          reject(err);
        },
      });
    });
  },
  

  async updatePhone({ commit, state }, data) {
    await PhoneProvider.update(state.phone.id, {
      data,
      success: (phone) => {
        commit("SET_PHONE", phone.phone);
      },
      error: (err) => {
        console.log("Erro ao buscar usuário", err);
      },
    });
  },

  async initializeUser({ dispatch }) {
    const userId = localStorage.getItem("userId");

    if (userId) {
      await dispatch("detailUser", userId);
    }
  },

  setStep({ commit }, step) {
    if(step <= 3 && step > 0){
      commit("SET_STEP", step);
    }
  },

  setUser({ commit }, user) {
    commit("SET_USER", user);
  },

  resetState({ commit }) {
    commit('RESET_STATE');
  },
};

const getters = {
  currentStep(state) {
    return state.step;
  },
  user(state) {
    return state.user;
  },
  address(state) {
    return state.address;
  },
  phone(state) {
    return state.phone;
  },
};

export default {
  namespaced: true,
  state,
  mutations,
  actions,
  getters,
};
