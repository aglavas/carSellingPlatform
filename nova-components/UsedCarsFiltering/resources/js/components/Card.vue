<template>
    <card class="flex flex-col items-center justify-center">
        <div class="px-3 py-3 w-full">
            <div class="text-right">
                <button
                        @click="reset"
                        class="btn btn-default btn-primary mb-2"
                >
                    <!-- py-2 block text-xs uppercase tracking-wide text-center text-80 dim font-bold focus:outline-none-->
                    {{ __('Reset Filters') }}
                </button>
            </div>
            <div class="flex flex-wrap">
                <dependency-filter v-for="filter in card.filters"
                                   v-if="!filter.hide"
                                   :card="card"
                                   :resource-name="resourceName"
                                   :key="filter.name"
                                   :filter-key="filter.class"
                                   :column="column(filter.class)"
                                   :lens="lens"
                                   :options="dependentOptions"
                                   :initial-options="filter.options"
                                   :width="filter.width"
                                   :updates="card.updates"
                                   @input="filterChanged(filter)"
                                   @change="filterChanged(filter)"
                />

            </div>
        </div>
    </card>
</template>

<script>
  import { Filterable, InteractsWithQueryString } from "laravel-nova";
  import DependencyFilter from "../../../../DependencyFilter/resources/js/components/Filter.vue"

export default {
    components: DependencyFilter,
    mixins: [Filterable, InteractsWithQueryString],
    props: [
      'card', 'initialDependentOptions'
      ]
      // The following props are only available on resource detail cards...
      // 'resource',
      // 'resourceId',
      // 'resourceName',
    ,
  data: function () {
    return {
      resourceName: this.card.resource,
      dependentOptions: {},
      hasUpdates: false
    }
  },
  mounted: function() {
      let encodedFilters = this.prepareRequest()

      this.checkForUpdates()

      axios.get('/nova-vendor/used-cars-filtering/filtered-options', {
          params: {
              filter: encodedFilters,
              model: this.card.model,
          }
      }).then(response => {
          for(var column in response.data) {
            if(typeof response.data[column] === 'object') {

            } else {
              let splittedOptions = response.data[column].split('|')

                let filters = this.card.filters
                let relation = false
                let relationClass = false

                filters.forEach(function (item) {
                    let regexMatch = item.class.match(/__(.*)__/)
                    let parsedColumn = regexMatch[1]

                    if (item.hasOwnProperty('relation') && item.relation == true && parsedColumn === column) {
                        relation = true
                        relationClass = item.class
                    }
                }, this)

                if (relation) {
                    this.dependentOptions[column] = splittedOptions.map(function(item) {
                        let label
                        filters.forEach(function (filter) {
                            if (filter.class === relationClass) {
                                filter.options.forEach(function (option) {
                                    if (option.value == item) {
                                        label = option.name
                                    }
                                }, this)
                            }
                        }, this)

                        return {'name': label, 'value': item, 'label': label}
                    }, this)
                } else {
                    this.dependentOptions[column] = splittedOptions.map(function(item) { return {'name': item, 'value': item, 'label': item}})
                }
            }
          }
          Nova.$emit('dependent-options-loaded', this.dependentOptions)
    })
  },

  methods: {
    column(filterClass) {
      return filterClass.match(/__(.*)__/)[1]
    },
    reset() {
      // TODO: Find a cleaner way to do the reset
      window.location = '/nova'+this.$router.currentRoute.path
    },
    filterChanged(filter) {
        let encodedFilters = this.prepareRequest()

      axios.get('/nova-vendor/used-cars-filtering/filtered-options', {
          params: {
              filter: encodedFilters,
              model: this.card.model,
          }
      }).then(response => {
          for(var column in response.data) {
              try {
                  if(typeof response.data[column] === 'object') {
                      this.dependentOptions[column] = {
                          'min': response.data[column].min,
                          'max': response.data[column].max
                      }
                  } else {
                      let splittedOptions = response.data[column].split('|')

                      let filters = this.card.filters
                      let relation = false
                      let relationClass = false

                      filters.forEach(function (item) {
                          let regexMatch = item.class.match(/__(.*)__/)
                          let parsedColumn = regexMatch[1]

                          if (item.hasOwnProperty('relation') && item.relation == true && parsedColumn === column) {
                              relation = true
                              relationClass = item.class
                          }
                      }, this)

                      if (relation) {
                          this.dependentOptions[column] = splittedOptions.map(function(item) {
                              let label
                              filters.forEach(function (filter) {
                                  if (filter.class === relationClass) {
                                      filter.options.forEach(function (option) {
                                          if (option.value == item) {
                                              label = option.name
                                          }
                                      }, this)
                                  }
                              }, this)

                              return {'name': label, 'value': item, 'label': label}
                          }, this)
                      } else {
                          this.dependentOptions[column] = splittedOptions.map(function(item) { return {'name': item, 'value': item, 'label': item}})
                      }
                  }
              } catch (e) {
                  this.dependentOptions[column] = []
              }
          }

        Nova.$emit('dependent-options-loaded', this.dependentOptions)
      })
      this.updateQueryString({
        [this.pageParameter]: 1,
        [this.filterParameter]: this.$store.getters[`${this.resourceName}/currentEncodedFilters`],
      })
    },
    prepareRequest() {
        let filters = this.$store.getters[`${this.resourceName}/filters`]

        let request = []

        filters.forEach(function (item) {
            request.push({
                class: item.class,
                value: item.currentValue,
                type: item.type
            })
        }, this)

        return btoa(JSON.stringify(request))
    }
  }
}
</script>
