import './styles/app.scss';
import '@yaireo/tagify/dist/tagify.css'

import Tagify from '@yaireo/tagify'

document.querySelectorAll('[tagify]').forEach(input => {
  const datalist = document.getElementById(`${input.id}-datalist`)
  const maxTags = datalist.getAttribute('max-tags') ?? Infinity
  const whitelist = [...datalist.options].map(({ value, textContent }) => ({
    id: value,
    value: textContent
  }))

  new Tagify(input, { whitelist, maxTags })
})

