import Tagify from '@yaireo/tagify'
import '@yaireo/tagify/dist/tagify.css'

class TagInputManager {
  _inputs = {}

  init() {
    document.querySelectorAll('[tagify]').forEach(({ id }) => this.register(id))
  }

  has(id) {
    return this._inputs.hasOwnProperty(id)
  }

  get(id) {
    return this._inputs[id]
  }

  register(id) {
    if (this._inputs[id]) {
      return
    }

    const input = document.getElementById(id)
    const datalist = document.getElementById(`${input.id}-datalist`)
    const maxTags = datalist.getAttribute('max-tags') ?? Infinity
    const enforceWhitelist = datalist.getAttribute('enforce') === 'true'
    const whitelist = [...datalist.options].map(({ value, textContent }) => optionToTag(value, textContent))

    this._inputs[id] = new Tagify(input, {
      whitelist,
      maxTags,
      enforceWhitelist,
      dropdown: { enabled: 0, maxItems: 5 }
    })
  }
}

export const tagInputManager = new TagInputManager()

export const optionToTag = (value, label) => ({ id: value, value: label })
