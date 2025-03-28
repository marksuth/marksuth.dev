var V=Object.defineProperty;var $=(e,t,o)=>t in e?V(e,t,{enumerable:!0,configurable:!0,writable:!0,value:o}):e[t]=o;var T=(e,t,o)=>$(e,typeof t!="symbol"?t+"":t,o);var M=class extends Event{constructor(t,{oldState:o="",newState:r="",...i}={}){super(t,i);T(this,"oldState");T(this,"newState");this.oldState=String(o||""),this.newState=String(r||"")}},N=new WeakMap;function j(e,t,o){N.set(e,setTimeout(()=>{N.has(e)&&e.dispatchEvent(new M("toggle",{cancelable:!1,oldState:t,newState:o}))},0))}var x=globalThis.ShadowRoot||function(){},G=globalThis.HTMLDialogElement||function(){},y=new WeakMap,l=new WeakMap,b=new WeakMap;function E(e){return b.get(e)||"hidden"}var m=new WeakMap;function K(e){const t=e.popoverTargetElement;if(!(t instanceof HTMLElement))return;const o=E(t);e.popoverTargetAction==="show"&&o==="showing"||e.popoverTargetAction==="hide"&&o==="hidden"||(o==="showing"?w(t,!0,!0):d(t,!1)&&(m.set(t,e),R(t)))}function d(e,t){return!(e.popover!=="auto"&&e.popover!=="manual"||!e.isConnected||t&&E(e)!=="showing"||!t&&E(e)!=="hidden"||e instanceof G&&e.hasAttribute("open")||document.fullscreenElement===e)}function O(e){return e?Array.from(l.get(e.ownerDocument)||[]).indexOf(e)+1:0}function Q(e){const t=z(e),o=U(e);return O(t)>O(o)?t:o}function S(e){const t=l.get(e);for(const o of t||[])if(!o.isConnected)t.delete(o);else return o;return null}function v(e){return typeof e.getRootNode=="function"?e.getRootNode():e.parentNode?v(e.parentNode):e}function z(e){for(;e;){if(e instanceof HTMLElement&&e.popover==="auto"&&b.get(e)==="showing")return e;if(e=e instanceof Element&&e.assignedSlot||e.parentElement||v(e),e instanceof x&&(e=e.host),e instanceof Document)return}}function U(e){for(;e;){const t=e.popoverTargetElement;if(t instanceof HTMLElement)return t;if(e=e.parentElement||v(e),e instanceof x&&(e=e.host),e instanceof Document)return}}function _(e){const t=new Map;let o=0;for(const a of l.get(e.ownerDocument)||[])t.set(a,o),o+=1;t.set(e,o),o+=1;let r=null;function i(a){const u=z(a);if(u===null)return null;const c=t.get(u);(r===null||t.get(r)<c)&&(r=u)}return i(e.parentElement||v(e)),r}function J(e){return e.hidden||e instanceof x||(e instanceof HTMLButtonElement||e instanceof HTMLInputElement||e instanceof HTMLSelectElement||e instanceof HTMLTextAreaElement||e instanceof HTMLOptGroupElement||e instanceof HTMLOptionElement||e instanceof HTMLFieldSetElement)&&e.disabled||e instanceof HTMLInputElement&&e.type==="hidden"||e instanceof HTMLAnchorElement&&e.href===""?!1:typeof e.tabIndex=="number"&&e.tabIndex!==-1}function X(e){if(e.shadowRoot&&e.shadowRoot.delegatesFocus!==!0)return null;let t=e;t.shadowRoot&&(t=t.shadowRoot);let o=t.querySelector("[autofocus]");if(o)return o;{const a=t.querySelectorAll("slot");for(const u of a){const c=u.assignedElements({flatten:!0});for(const n of c){if(n.hasAttribute("autofocus"))return n;if(o=n.querySelector("[autofocus]"),o)return o}}}const r=e.ownerDocument.createTreeWalker(t,NodeFilter.SHOW_ELEMENT);let i=r.currentNode;for(;i;){if(J(i))return i;i=r.nextNode()}}function Y(e){var t;(t=X(e))==null||t.focus()}var A=new WeakMap;function R(e){if(!d(e,!1))return;const t=e.ownerDocument;if(!e.dispatchEvent(new M("beforetoggle",{cancelable:!0,oldState:"closed",newState:"open"}))||!d(e,!1))return;let o=!1;if(e.popover==="auto"){const i=e.getAttribute("popover"),a=_(e)||t;if(L(a,!1,!0),i!==e.getAttribute("popover")||!d(e,!1))return}S(t)||(o=!0),A.delete(e);const r=t.activeElement;e.classList.add(":popover-open"),b.set(e,"showing"),y.has(t)||y.set(t,new Set),y.get(t).add(e),Y(e),e.popover==="auto"&&(l.has(t)||l.set(t,new Set),l.get(t).add(e),B(m.get(e),!0)),o&&r&&e.popover==="auto"&&A.set(e,r),j(e,"closed","open")}function w(e,t=!1,o=!1){var a,u;if(!d(e,!0))return;const r=e.ownerDocument;if(e.popover==="auto"&&(L(e,t,o),!d(e,!0))||(B(m.get(e),!1),m.delete(e),o&&(e.dispatchEvent(new M("beforetoggle",{oldState:"open",newState:"closed"})),!d(e,!0))))return;(a=y.get(r))==null||a.delete(e),(u=l.get(r))==null||u.delete(e),e.classList.remove(":popover-open"),b.set(e,"hidden"),o&&j(e,"open","closed");const i=A.get(e);i&&(A.delete(e),t&&i.focus())}function W(e,t=!1,o=!1){let r=S(e);for(;r;)w(r,t,o),r=S(e)}function L(e,t,o){var u;const r=e.ownerDocument||e;if(e instanceof Document)return W(r,t,o);let i=null,a=!1;for(const c of l.get(r)||[])if(c===e)a=!0;else if(a){i=c;break}if(!a)return W(r,t,o);for(;i&&E(i)==="showing"&&((u=l.get(r))!=null&&u.size);)w(i,t,o)}var P=new WeakMap;function C(e){if(!e.isTrusted)return;const t=e.composedPath()[0];if(!t)return;const o=t.ownerDocument;if(!S(o))return;const i=Q(t);if(i&&e.type==="pointerdown")P.set(o,i);else if(e.type==="pointerup"){const a=P.get(o)===i;P.delete(o),a&&L(i||o,!1,!0)}}var H=new WeakMap;function B(e,t=!1){if(!e)return;H.has(e)||H.set(e,e.getAttribute("aria-expanded"));const o=e.popoverTargetElement;if(o instanceof HTMLElement&&o.popover==="auto")e.setAttribute("aria-expanded",String(t));else{const r=H.get(e);r?e.setAttribute("aria-expanded",r):e.removeAttribute("aria-expanded")}}var q=globalThis.ShadowRoot||function(){};function Z(){return typeof HTMLElement<"u"&&typeof HTMLElement.prototype=="object"&&"popover"in HTMLElement.prototype}function f(e,t,o){const r=e[t];Object.defineProperty(e,t,{value(i){return r.call(this,o(i))}})}var ee=/(^|[^\\]):popover-open\b/g;function te(){return typeof globalThis.CSSLayerBlockRule=="function"}function oe(){const e=te();return`
${e?"@layer popover-polyfill {":""}
  :where([popover]) {
    position: fixed;
    z-index: 2147483647;
    inset: 0;
    padding: 0.25em;
    width: fit-content;
    height: fit-content;
    border-width: initial;
    border-color: initial;
    border-image: initial;
    border-style: solid;
    background-color: canvas;
    color: canvastext;
    overflow: auto;
    margin: auto;
  }

  :where([popover]:not(.\\:popover-open)) {
    display: none;
  }

  :where(dialog[popover].\\:popover-open) {
    display: block;
  }

  :where(dialog[popover][open]) {
    display: revert;
  }

  :where([anchor].\\:popover-open) {
    inset: auto;
  }

  :where([anchor]:popover-open) {
    inset: auto;
  }

  @supports not (background-color: canvas) {
    :where([popover]) {
      background-color: white;
      color: black;
    }
  }

  @supports (width: -moz-fit-content) {
    :where([popover]) {
      width: -moz-fit-content;
      height: -moz-fit-content;
    }
  }

  @supports not (inset: 0) {
    :where([popover]) {
      top: 0;
      left: 0;
      right: 0;
      bottom: 0;
    }
  }
${e?"}":""}
`}var h=null;function D(e){const t=oe();if(h===null)try{h=new CSSStyleSheet,h.replaceSync(t)}catch{h=!1}if(h===!1){const o=document.createElement("style");o.textContent=t,e instanceof Document?e.head.prepend(o):e.prepend(o)}else e.adoptedStyleSheets=[h,...e.adoptedStyleSheets]}function ne(){if(typeof window>"u")return;window.ToggleEvent=window.ToggleEvent||M;function e(n){return n!=null&&n.includes(":popover-open")&&(n=n.replace(ee,"$1.\\:popover-open")),n}f(Document.prototype,"querySelector",e),f(Document.prototype,"querySelectorAll",e),f(Element.prototype,"querySelector",e),f(Element.prototype,"querySelectorAll",e),f(Element.prototype,"matches",e),f(Element.prototype,"closest",e),f(DocumentFragment.prototype,"querySelectorAll",e),Object.defineProperties(HTMLElement.prototype,{popover:{enumerable:!0,configurable:!0,get(){if(!this.hasAttribute("popover"))return null;const n=(this.getAttribute("popover")||"").toLowerCase();return n===""||n=="auto"?"auto":"manual"},set(n){n===null?this.removeAttribute("popover"):this.setAttribute("popover",n)}},showPopover:{enumerable:!0,configurable:!0,value(){R(this)}},hidePopover:{enumerable:!0,configurable:!0,value(){w(this,!0,!0)}},togglePopover:{enumerable:!0,configurable:!0,value(n){b.get(this)==="showing"&&n===void 0||n===!1?w(this,!0,!0):(n===void 0||n===!0)&&R(this)}}});const t=Element.prototype.attachShadow;t&&Object.defineProperties(Element.prototype,{attachShadow:{enumerable:!0,configurable:!0,writable:!0,value(n){const s=t.call(this,n);return D(s),s}}});const o=HTMLElement.prototype.attachInternals;o&&Object.defineProperties(HTMLElement.prototype,{attachInternals:{enumerable:!0,configurable:!0,writable:!0,value(){const n=o.call(this);return n.shadowRoot&&D(n.shadowRoot),n}}});const r=new WeakMap;function i(n){Object.defineProperties(n.prototype,{popoverTargetElement:{enumerable:!0,configurable:!0,set(s){if(s===null)this.removeAttribute("popovertarget"),r.delete(this);else if(s instanceof Element)this.setAttribute("popovertarget",""),r.set(this,s);else throw new TypeError("popoverTargetElement must be an element or null")},get(){if(this.localName!=="button"&&this.localName!=="input"||this.localName==="input"&&this.type!=="reset"&&this.type!=="image"&&this.type!=="button"||this.disabled||this.form&&this.type==="submit")return null;const s=r.get(this);if(s&&s.isConnected)return s;if(s&&!s.isConnected)return r.delete(this),null;const p=v(this),g=this.getAttribute("popovertarget");return(p instanceof Document||p instanceof q)&&g&&p.getElementById(g)||null}},popoverTargetAction:{enumerable:!0,configurable:!0,get(){const s=(this.getAttribute("popovertargetaction")||"").toLowerCase();return s==="show"||s==="hide"?s:"toggle"},set(s){this.setAttribute("popovertargetaction",s)}}})}i(HTMLButtonElement),i(HTMLInputElement);const a=n=>{const s=n.composedPath(),p=s[0];if(!(p instanceof Element)||p!=null&&p.shadowRoot)return;const g=v(p);if(!(g instanceof q||g instanceof Document))return;const I=s.find(k=>{var F;return(F=k.matches)==null?void 0:F.call(k,"[popovertargetaction],[popovertarget]")});if(I){K(I),n.preventDefault();return}},u=n=>{const s=n.key,p=n.target;!n.defaultPrevented&&p&&(s==="Escape"||s==="Esc")&&L(p.ownerDocument,!0,!0)};(n=>{n.addEventListener("click",a),n.addEventListener("keydown",u),n.addEventListener("pointerdown",C),n.addEventListener("pointerup",C)})(document),D(document)}Z()||ne();
