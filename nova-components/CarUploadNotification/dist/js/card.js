!function(e){var t={};function n(r){if(t[r])return t[r].exports;var o=t[r]={i:r,l:!1,exports:{}};return e[r].call(o.exports,o,o.exports,n),o.l=!0,o.exports}n.m=e,n.c=t,n.d=function(e,t,r){n.o(e,t)||Object.defineProperty(e,t,{configurable:!1,enumerable:!0,get:r})},n.n=function(e){var t=e&&e.__esModule?function(){return e.default}:function(){return e};return n.d(t,"a",t),t},n.o=function(e,t){return Object.prototype.hasOwnProperty.call(e,t)},n.p="",n(n.s=0)}([function(e,t,n){n(1),e.exports=n(6)},function(e,t,n){Nova.booting(function(e,t,r){e.component("carUploadNotification",n(2))})},function(e,t,n){var r=n(3)(n(4),n(5),!1,null,null,null);e.exports=r.exports},function(e,t){e.exports=function(e,t,n,r,o,i){var s,c=e=e||{},a=typeof e.default;"object"!==a&&"function"!==a||(s=e,c=e.default);var u,l="function"==typeof c?c.options:c;if(t&&(l.render=t.render,l.staticRenderFns=t.staticRenderFns,l._compiled=!0),n&&(l.functional=!0),o&&(l._scopeId=o),i?(u=function(e){(e=e||this.$vnode&&this.$vnode.ssrContext||this.parent&&this.parent.$vnode&&this.parent.$vnode.ssrContext)||"undefined"==typeof __VUE_SSR_CONTEXT__||(e=__VUE_SSR_CONTEXT__),r&&r.call(this,e),e&&e._registeredComponents&&e._registeredComponents.add(i)},l._ssrRegister=u):r&&(u=r),u){var f=l.functional,d=f?l.render:l.beforeCreate;f?(l._injectStyles=u,l.render=function(e,t){return u.call(t),d(e,t)}):l.beforeCreate=d?[].concat(d,u):[u]}return{esModule:s,exports:c,options:l}}},function(e,t,n){"use strict";Object.defineProperty(t,"__esModule",{value:!0}),t.default={props:["card"],mounted:function(){Nova.$emit("test-event")}}},function(e,t){e.exports={render:function(){var e=this,t=e.$createElement,n=e._self._c||t;return n("card",{staticClass:"flex flex-col flexible-height"},[n("div",{staticClass:"px-6 py-4"},[n("h1",{staticClass:"text-3xl text-80 font-light pb-4"},[e._v("Vehicle updates")]),e._v(" "),n("div",[n("ul",e._l(this.card.carUploadNotification,function(t){return n("li",[n("b",[e._v(e._s(t.type))]),e._v(" "+e._s(t.label)+"\n                    "),n("router-link",{staticClass:"text-black text-justify no-underline dim",attrs:{to:{name:"index",params:{resourceName:t.uriKey}}}},[n("b",[e._v("Show vehicles")])])],1)}),0)])])])},staticRenderFns:[]}},function(e,t){}]);