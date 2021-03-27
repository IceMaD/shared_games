export default class Filters {
  _filters = {
    selectedTags: [],
    userIds: [],
    gameName: ''
  }

  /**
   * @private
   * @type {GameRow[]}
   */
  _gameRows

  constructor(gameRows) {
    this._gameRows = gameRows
  }

  setSelectedTags(selectedTags) {
    this._filters.selectedTags = selectedTags

    this.filter()
  }

  setGameName(name) {
    this._filters.gameName = name

    this.filter()
  }

  toggleUser(userId) {
    if (this.hasUser(userId)) {
      this._filters.userIds = this._filters.userIds.filter(id => id !== userId)
    } else {
      this._filters.userIds = [...this._filters.userIds, userId]
    }

    this.filter()
  }

  hasUser(userId) {
    return this._filters.userIds.includes(userId)
  }

  filter() {
    this._gameRows.forEach(gameRow => {
      if (!gameRow.name.toLowerCase().includes(this._filters.gameName.toLowerCase())) {
        return gameRow.hide()
      }

      if (0 < this._filters.selectedTags.length && 0 === gameRow.tags.filter(value => this._filters.selectedTags.includes(value)).length) {
        return gameRow.hide()
      }

      if (0 < this._filters.userIds.length && !this._filters.userIds.every(val => gameRow.users.includes(val))) {
        return gameRow.hide()
      }

      return gameRow.show()
    })
  }
}
