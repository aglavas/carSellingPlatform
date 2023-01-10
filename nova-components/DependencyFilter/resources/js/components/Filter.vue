<template>
    <div :class="filter.width">
        <h3 class="text-sm uppercase tracking-wide text-80 bg-30 p-3" v-if="!filter.notification">
            {{ filter.name }}
        </h3>
        <div class="p-2">
            <select
                v-if="filter.multiple === false && filter.range === false"
                :dusk="filter.name + '-filter-select'"
                class="block w-full form-control-sm form-select"
                @change="handleChange"
            >
                <option value="" selected>&mdash;</option>
                <option v-for="option in options" :value="option.value" :key="option.value">
                    {{ option.name }}
                </option>
            </select>
            <div tabindex="-1" class="flex h-auto block w-full form-control-sm form-select" v-if="filter.multiple === true">
                <div v-if="selected.length === 0" class="h-8 pt-1 leading-normal">&mdash;</div>
                <ul v-else ref="selected" class="list-reset flex flex-wrap text-sm -ml-2 pb-1">
                    <li v-for="option, index in selected" @click="remove(index)" :class="option.value" class="bg-primary text-white rounded -ml-0 mt-1 mr-1 px-2 py-1 hover:bg-primary-dark">
                        {{ option.name }}
                    </li>
                </ul>
                <ul v-if="showDropdown && availableOptions.length" class="list-reset absolute top-auto w-1/2 -ml-6 py-1 border border-60 rounded-lg bg-30 z-50" >
                    <li v-for="option in availableOptions" @click="select(option)" class="truncate max-w-full px-3 py-1 hover:text-white hover:bg-primary-dark">
                        {{ option.name }}
                    </li>
                </ul>
            </div>
            <vue-slider
                    v-if="filter.range === true"
                    :value="rangeValue"
                    :lazy="true"
                    :tooltip="'always'"
                    :min="minOption"
                    :max="maxOption"
                    tooltip-placement="bottom"
                    ref="slider"
                    @change="handleRangeChange"/>
            <div
                v-if="filter.notification && this.hasUpdates"
            >
                <button
                    class="btn btn-default btn-primary mb-2 to-right"
                    @click="showUpdates"
                >
                    <!-- py-2 block text-xs uppercase tracking-wide text-center text-80 dim font-bold focus:outline-none-->
                    {{ __('Show updated cars since last login') }}
                </button>
            </div>

        </div>
    </div>
</template>

<script>

  import VueSlider from 'vue-slider-component'
  import 'vue-slider-component/theme/default.css'

  export default {
    components: {
      VueSlider
    },
    props: {
        resourceName: {
            type: String,
            required: true,
        },
        filterKey: {
            type: String,
            required: true,
        },
        updates: {
            required: false,
            default: null
        },
        card: {
          type: Object
        },
      initialOptions: {
            type: Array
      },
      column: {
          type: String
      }
    },
  data: function () {
    return {
      options: {},
      hasUpdates: false,
      selected: [],
      showDropdown: false
    }
  },
  mounted: function() {
    document.addEventListener('click', this.toggle);
    Nova.$on('dependent-options-loaded', this.handlePayload)
    this.checkForUpdates()

    if (this.column == 'brand') {
        this.options = this.initialOptions
    }
  },
    methods: {
          select(option) {
            //this.showDropdown = false;
            this.selected.push(option);
          },
        handlePayload(payload) {
            if (this.column != 'brand') {
                this.options = payload[this.column]
            }
        },
      remove(index) {
        this.selected.splice(index, 1);
      },
      toggle(event) {
        if(this.$el.contains(event.target) && this.availableOptions.length > 0) {
          this.showDropdown = !this.showDropdown;
        }
        else {
          this.showDropdown = false;
        }
      },
        checkForUpdates() {
            if (Object.keys(this.updates).length !== 0) {
                this.hasUpdates = true
            }
        },
        showUpdates() {
            this.$store.commit(`${this.resourceName}/updateFilterState`, {
                filterClass: this.filterKey,
                value: Object.values(this.updates),
            })

            this.$emit('change')

            // axios.post('/nova-vendor/used-cars-filtering/notification/seen', {
            //     params: {
            //         list_type: this.card.listType,
            //     }
            // })
            //
            // this.hasUpdates = false
        },
        handleChange(event) {
            this.$store.commit(`${this.resourceName}/updateFilterState`, {
                filterClass: this.filterKey,
                value: event.target.value,
            })
            this.$emit('change')
        },
      handleRangeChange(event) {

        this.$store.commit(`${this.resourceName}/updateFilterState`, {
          filterClass: this.filterKey,
          value: {
            min: event[0],
            max: event[1],
          },
        })
        this.$emit('change')
      },
    },
/*
TODO:
Return minOption and maxOption from this.options
 */
    computed: {
      sliderSettings() {
            if(typeof this.options === 'undefined') {
              return {
                min: this.initialOptions[0].value,
                max: this.initialOptions[1].value
              }
            }
            return {
              min: this.options.min,
              max: this.options.max
            }
      },
      rangeValue() {
        return [this.sliderSettings.min,this.sliderSettings.max]
      },
      minOption() {
            return this.initialOptions[0].value;
      },
      maxOption() {
            return this.initialOptions[1].value;
      },
      availableOptions() {
        return this.options.filter(option => !this.selected.includes(option));
      },
        filter() {
            return this.$store.getters[`${this.resourceName}/getFilter`](
                this.filterKey
            )
        },
    },
    watch: {
      selected: function() {
        this.$store.commit(`${this.resourceName}/updateFilterState`, {
          filterClass: this.filterKey,
          value: this.selected.map(e => e.value),
        })
        this.$emit('change')
      }
    }
}
</script>
