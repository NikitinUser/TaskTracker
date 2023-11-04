const { defineConfig } = require('@vue/cli-service')
module.exports = defineConfig({
  transpileDependencies: true,
  outputDir: "../../public/js/vue_compiled",
  filenameHashing: false,
})
