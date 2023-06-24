function toggleMenu() {
    var menu = document.getElementById("menu");
    if (menu.style.display === "block") {
        menu.style.display = "none";
    } else {
        menu.style.display = "block";
    }
}

function toggleCompte() {
    var compte = document.getElementById("compte");
    if (compte.style.display === "block") {
        compte.style.display = "none";
    } else {
        compte.style.display = "block";
    }
}

function ChangeBackgroundColor() {
    var html = document.documentElement;
    backgroundColor = html.style.backgroundColor;

    if (backgroundColor === '#white' || backgroundColor === '') {
        html.style.backgroundColor = '#d9b9b9';
    } else {
        html.style.backgroundColor = '#white';
    }
}

function telecharger_image(url, new_image) {
    return new Promise((resolve, reject) => {
      const dirPath = path.resolve(__dirname, 'images_recettes');
      if (!fs.existsSync(dirPath)) {
        fs.mkdirSync(dirPath);
      }
  
      const filePath = path.resolve(dirPath, new_image + '.jpg');
      const file = fs.createWriteStream(filePath);
      const request = https.get(url, function (response) {
        response.pipe(file);
        file.on('finish', function () {
          file.close();
          resolve(filePath);
        });
      }).on('error', function (err) {
        fs.unlink(filePath, () => {
          reject(err);
        });
      });
    });
  }
  module.exports = telecharger_image;

  function fichierExiste(filePath) {
    return fs.existsSync(filePath);
  }

    module.exports = fichierExiste;