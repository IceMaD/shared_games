import '@yaireo/tagify/dist/tagify.css'

import TagInputManager from './scripts/TagInputManager'
import './styles/app.scss'

const tagInputManager = new TagInputManager()

tagInputManager.init()

document.querySelectorAll('table[filtered-by]').forEach(table => {
  const filterFormId = table.getAttribute('filtered-by');

  if (!tagInputManager.has(filterFormId)) {
    throw 'Meh';
  }

  const rows = [...table.querySelectorAll('tbody tr')].map(tr => ({tr, tags: JSON.parse(tr.getAttribute('tags'))}))

  tagInputManager.get('filter_games_tags')
    .on('change', ({detail}) => {
      const selectedTags = detail.tagify.value.map(tag => parseInt(tag.id, 10))

      rows.forEach(({ tr, tags}) => {
        if (0 === selectedTags.length || tags.filter(value => selectedTags.includes(value)).length > 0) {
          tr.style.display = null
        } else {
          tr.style.display = 'none'
        }
      })
    })
})
