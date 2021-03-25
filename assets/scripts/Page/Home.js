import FilterManager from '../Filter/FilterManager'
import GameRow from '../Filter/GameRow'
import {optionToTag, tagInputManager} from '../TagInputManager'

const allGamesTable = document.getElementById('all_games')

if (allGamesTable) {
  tagInputManager.init()

  const rows = [...allGamesTable.querySelectorAll('tbody tr')].map(tr => new GameRow(tr))
  const gameInput = document.getElementById('filter_games_game')
  const filterManager = new FilterManager(rows)

  // Bind in-table tags
  allGamesTable.querySelectorAll('[filter-tag]').forEach(filterTag => {
    filterTag.addEventListener('click', () => {
      tagInputManager
        .get('filter_games_tags')
        .addTags([optionToTag(filterTag.getAttribute('filter-tag'), filterTag.textContent)])
    })
  })

  // Bind tag picker
  tagInputManager
    .get('filter_games_tags')
    .on('change', event => filterManager.setSelectedTags(event.detail.tagify.value.map(tag => parseInt(tag.id, 10))))

  // Bind game search
  gameInput.addEventListener('keyup', event => filterManager.setGameName(event.target.value))
  gameInput.addEventListener('blur', event => filterManager.setGameName(event.target.value))

  // Bind user header
  allGamesTable.querySelectorAll('thead td[user]').forEach(td => {
    const userId = parseInt(td.getAttribute('user'), 10)

    td.addEventListener('click', () => {
      filterManager.toggleUser(userId)

      if (filterManager.hasUser(userId)) {
        td.classList.add('selected')
      } else {
        td.classList.remove('selected')
      }
    })
  })
}
