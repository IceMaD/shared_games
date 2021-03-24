import Tagify from '@yaireo/tagify'

class TagInputManager {
  _inputs = {}

  init () {
    document.querySelectorAll('[tagify]').forEach(({ id }) => this.register(id))
  }

  has (id) {
    return this._inputs.hasOwnProperty(id)
  }

  get (id) {
    return this._inputs[id]
  }

  register(id) {
    const input = document.getElementById(id)
    const datalist = document.getElementById(`${input.id}-datalist`)
    const maxTags = datalist.getAttribute('max-tags') ?? Infinity
    const enforceWhitelist = datalist.getAttribute('enforce') === 'true';
    const whitelist = [...datalist.options].map(({ value, textContent }) => ({
      id: value,
      value: textContent
    }))

    this._inputs[id] = new Tagify(input, { whitelist, maxTags, enforceWhitelist, dropdown: {enabled: 0, maxItems: 5} });
  }
}

export default TagInputManager
