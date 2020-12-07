
        <div class="titulo">
          descubra
        </div>

        <div>
          <ul>
            <li><a href="index.php">Geral</a></li>
            <li><a href="index.php?page=hortalica">Hortaliças</a></li>       
            <li><a href="index.php?page=tuberculo">Tubérculos</a></li> 
            <li><a href="index.php?page=verdura">Verduras</a></li>    
            <li><a href="index.php?page=legume">Legumes</a></li>
            <li><a href="index.php?page=fruta" class="active">Frutas</a></li>
            <li><a href="index.php?page=especiaria">Especiarias</a></li>
          </ul>
        </div>

  <?php
  $postagem = mysql_query("SELECT * FROM planta WHERE categoria='Fruta' ORDER BY id DESC");
      echo '<div class="flex-wrap">'; 

  while($planta=mysql_fetch_assoc($postagem)){
      $id = $planta['id'];

          echo '<a style="display:block;text-decoration:none;color:black;"   href="plt.php?tag='.$id.'">
              <div class="col-3 center">
              <div style="background-image: url(upload/'.$planta['imagem'].')" class="caixaplanta">

            </div>
            <p class="nomes">'.$planta['nome']. '</p><p class="nomes_c">' .$planta["nome_cient"].'<p></a> 
          </div>';
      }
  ?>

              
            </div>
          </div>
          </div>

        </div>

      </div>

    </div>



    <script src="script.js"></script>
  </body>
</html>
