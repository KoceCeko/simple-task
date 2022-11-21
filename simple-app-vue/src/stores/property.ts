import { ref, computed } from "vue";
import { defineStore } from "pinia";
import axios from "axios";

interface Property {
  id: string;
  name: string;
  price: number;
  bedrooms: number;
  bathrooms: number;
  storeys: number;
  garages: number;
}

interface Response<T> {
  data: T;
}

const mapFilters = (filters: any) => {
  if (filters) {
    const retValue =
      "?" +
      Object.keys(filters).map((key) => {
        return filters[key] ? key + "=" + filters[key] : "";
      });
    return retValue.replaceAll(",", "&");
  }
  return "";
};
export const usePropertyStore = defineStore("property", {
  state: () => {
    return { data: [] as Property[], loading: true };
  },
  getters: {
    getData: (state): any[] => {
      return state.data;
    },
    getLoading: (state) => {
      return state.loading;
    },
  },
  actions: {
    async fetchData(filters: any = undefined) {
      this.loading = true;
      await axios
        .get<Response<Property[]>>(
          "http://localhost:8000/api/property" + mapFilters(filters)
        )
        .then((res) => {
          this.data = res.data.data;
          this.loading = false;
        })
        .catch((err) => console.log("Error", err));
    },
  },
});
