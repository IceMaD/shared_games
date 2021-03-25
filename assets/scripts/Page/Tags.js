import PickerManager from '../PickerManager'

document.querySelectorAll('[emoji-pick]').forEach(button => {
  button.addEventListener('click', () => {
    PickerManager.append(button, emoji => {
      const form = button.closest('form')
      const hidden = form.querySelector('[emoji-hidden]')

      hidden.value = emoji

      form.submit()
    })
  })
})
