<script lang="ts">
import { computed } from "vue";
import DataTable from "primevue/datatable";
import Column from "primevue/column";
import { FilterMatchMode, FilterOperator } from "primevue/api";
import Button from "primevue/button";
import InputText from "primevue/inputtext";
import InputNumber from "primevue/inputnumber";
import ProgressSpinner from "primevue/progressspinner";
import { usePropertyStore } from "@/stores/property";

export default {
  setup() {
    const store = usePropertyStore();
    return { store };
  },
  components: {
    DataTable,
    Column,
    ProgressSpinner,
    Button,
    InputText,
    InputNumber,
  },
  mounted() {
    this.store.fetchData();
  },
  data() {
    return {
      filters: {
        name: {
          value: null,
          type: "text",
          matchMode: FilterMatchMode.CONTAINS,
          placeholder: "Search by name - ",
        },
        price: {
          value: null,
          valueTo: null,
          matchMode: FilterMatchMode.STARTS_WITH,
        },
        bathrooms: {
          value: null,
          type: "text",
          matchMode: FilterMatchMode.EQUALS,
          placeholder: "Number of bathrooms - ",
        },
        storeys: {
          value: null,
          type: "text",
          matchMode: FilterMatchMode.EQUALS,
          placeholder: "Number of storeys - ",
        },
        garages: {
          value: null,
          type: "text",
          matchMode: FilterMatchMode.EQUALS,
          placeholder: "Number of garages - ",
        },
      },
      price_from: null,
      price_to: null,
      filterOutput: {} as any,
    };
  },
  methods: {
    filterCallback(field: string, value: any) {
      this.filterOutput[field] = value;
      this.store.fetchData(this.filterOutput);
    },
    getName(value: string) {
      return value.charAt(0).toUpperCase() + value.slice(1);
    },
  },
};
</script>

<template>
  <main class="container">
    <DataTable
      :value="store.getData"
      dataKey="id"
      v-model:filters="filters"
      filterDisplay="row"
      :loading="store.getLoading"
      responsiveLayout="scroll"
      :globalFilterFields="['name']"
    >
      <template #empty> No property found. </template>
      <template #loading>
        <div>Loading property data. Please wait.</div></template
      >

      <template v-for="key in Object.keys(filters)">
        <template v-if="key.includes('name')">
          <Column :field="key" :header="getName(key)">
            <template #body="{ data }">
              {{ data[key] }}
            </template>
            <template #filter="{ filterModel, field }">
              <InputText
                type="text"
                v-model="filterModel.value"
                @keydown.enter="filterCallback(field, filterModel.value)"
                :placeholder="filterModel.placeholder"
              />
            </template>
          </Column>
        </template>
        <template v-else-if="key.includes('price')">
          <Column field="price" header="Price">
            <template #body="{ data }">
              {{ data.price }}
            </template>
            <template #filter="{ filterModel, field }">
              <div class="number-filter" :v-model="filterModel.value">
                <InputNumber
                  type="number"
                  v-model:modelValue="filterModel.value"
                  @keydown.enter="
                    filterCallback('price_from', filterModel.value)
                  "
                  :placeholder="`Price from -`"
                />
                <InputNumber
                  type="number"
                  v-model:modelValue="filterModel.valueTo"
                  @keydown.enter="
                    filterCallback('price_to', filterModel.valueTo)
                  "
                  :placeholder="`Price to -`"
                />
              </div>
            </template>
          </Column>
        </template>
        <template v-else>
          <Column :field="key" :header="getName(key)">
            <template #body="{ data }">
              {{ data[key] }}
            </template>
            <template #filter="{ filterModel, field }">
              <InputNumber
                type="number"
                v-model="filterModel.value"
                @keydown.enter="filterCallback(field, filterModel.value)"
                :placeholder="filterModel.placeholder"
              />
            </template>
          </Column>
        </template>
      </template>
    </DataTable>
  </main>
</template>

<style scoped>
.container {
  display: flex;
  margin-top: 50px;
  justify-content: center;
  width: max-content;
  max-width: 100%;
  min-height: 100vh;
}
.number-filter {
  display: flex;
  align-items: row;
}
.custom-column {
  width: 200px;
}
</style>
