<template>
    <div v-show="loading || !filter.hideWhenEmpty || availableOptions.length > 0">
        <h3 class="text-sm uppercase tracking-wide text-80 bg-30 p-3">{{ filter.name }}</h3>

        <div class="p-2">
            <select-control
                    v-if="filter.multiple === false && filter.range === false"
                    :dusk="`${filter.name}-filter-select`"
                    class="block w-full form-control-sm form-select"
                    :value="value"
                    @change="handleChange($event.target.value)"
                    :options="availableOptions"
                    :label="optionValue"
                    :selected="value"
            >
                <option value="" selected>&mdash;</option>
            </select-control>
            <local-select-multiple
                    v-if="filter.multiple === true"
                    :dusk="filter.name + '-filter-select'"
                    class="block w-full form-control-sm form-select"
                    :options="availableOptions"
                    :value="value"
                    @change="handleChange"
            />
            <vue-slider
                    v-if="filter.range === true"
                    :value="value"
                    :lazy="true"
                    :tooltip="'always'"
                    :min="minOption"
                    :max="maxOption"
                    ref="slider"
                    @change="handleChange"/>
        </div>
    </div>
</template>

<script>
  import LocalSelectMultiple from '../../../../LocalMultiselectFilter/resources/js/components/LocalSelectMultiple'
  import VueSlider from 'vue-slider-component'
  import 'vue-slider-component/theme/default.css'

  export default {
    components: {
      LocalSelectMultiple,
      VueSlider
    },
    props: {
      resourceName: {
        type: String,
        required: true,
      },
      lens: String,
      filterKey: {
        type: String,
        required: true,
      },
    },

    data: () => ({
      options: [],
      loading: false,
      lastMin: 0,
      lastMax: 0
    }),

    created() {
      this.options = this.filter.options

      this.$watch(() => {
        this.loading = true;
        this.fetchOptions(this.filter.dependentOf.reduce((r, filter) => {
          r[filter] = this.$store.getters[`${this.resourceName}/getFilter`](filter).currentValue;
          return r;
        }, {}));
      });
    },

    methods: {
      handleChange(value) {
        this.$store.commit(`${this.resourceName}/updateFilterState`, {
          filterClass: this.filterKey,
          value: value,
        })

        this.$emit('change')
      },

      optionValue(option) {
        return option.label || option.name || option.value
      },

      async fetchOptions(filters) {
        const lens = this.lens ? `/lens/${this.lens}` : ''
        const {data: options} = await Nova.request().get(`/nova-api/${this.resourceName}${lens}/filters/options`, {
          params: {
            filters: btoa(JSON.stringify(filters)),
            filter: this.filterKey,
          },
        })

        this.options = options
        this.loading = false
      }
    },

    computed: {
      filter() {
        return this.$store.getters[`${this.resourceName}/getFilter`](this.filterKey)
      },

      value() {
        return this.filter.currentValue
      },

      minOption () {
        this.lastMin = _.minBy(this.availableOptions, 'name')['name']
        if (this.value[0] < this.lastMin) {
          this.value[0] = this.lastMin
        }
        return _.minBy(this.availableOptions, 'name')['name']
      },
      maxOption () {
        this.lastMax = _.maxBy(this.availableOptions, 'name')['name']
        if (this.value[1] > this.lastMax) {
          this.value[1] = this.lastMax
        }
        return _.maxBy(this.availableOptions, 'name')['name']
      },

      availableOptions() {
        let options = _.filter(this.options, option => {
          return !option.hasOwnProperty('depends') || _.every(option.depends, (values, filterName) => {
            const filter = this.$store.getters[`${this.resourceName}/getFilter`](filterName)
            if (!filter) return true
            if (filter.currentValue == "") return true
            if (filter.range && values >= filter.currentValue[0] && values <= filter.currentValue[1]) return true

            return _.intersection(
              _.castArray(filter.currentValue).map(String),
              _.castArray(values).map(String)
            ).length > 0;
          })
        })
        if (!this.loading && this.value !== '' && options.filter(option => option.value == this.value).length === 0 ) {
          this.handleChange('')
        }
        return _.uniqBy(options, 'value')
      },
    },
  }
</script>