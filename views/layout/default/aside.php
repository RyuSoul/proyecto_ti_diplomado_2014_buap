
    <aside>
        <!-- Codrops top bar -->
        <section class="ac-container">
            <div>
                <input id="ac-1" name="accordion-1" type="radio" checked />
                <label for="ac-1"><img src="<?php echo $_layoutParams['ruta_img'];?>pacient.png"><span>Pacientes</span></label>
                <article class="ac-small">
                    <ul class="listOptions">
                        <?php if(isset($_layoutParams['menuPaciente'])):?>
                            <?php foreach($_layoutParams['menuPaciente'] as $element): ?>
                                <li><a href="<?php echo $element['enlace'];?>"><?php echo $element['titulo'];?></a></li>
                            <?php endforeach;?>
                        <?php endif; ?>
                    </ul>
                </article>
            </div>

            <div>
                <input id="ac-2" name="accordion-1" type="radio" />
                <label for="ac-2"><img src="<?php echo $_layoutParams['ruta_img'];?>PatientFile.png"><span>Expedientes</span></label>
                <article class="ac-medium">
                    <ul class="listOptions">
                        <?php if(isset($_layoutParams['menuExpedientes'])):?>
                            <?php foreach($_layoutParams['menuExpedientes'] as $element): ?>
                                <li><a href="<?php echo $element['enlace'];?>"><?php echo $element['titulo'];?></a></li>
                            <?php endforeach;?>
                        <?php endif; ?>
                    </ul>
                </article>
            </div>
            <div>
                <input id="ac-3" name="accordion-1" type="radio" />
                <label for="ac-3"><img src="<?php echo $_layoutParams['ruta_img'];?>nurse.png"><span>Enfermeras</span></label>
                <article class="ac-small">
                    <ul class="listOptions">
                        <?php if(isset($_layoutParams['menuNurse'])):?>
                            <?php foreach($_layoutParams['menuNurse'] as $element): ?>
                                <li><a href="<?php echo $element['enlace'];?>"><?php echo $element['titulo'];?></a></li>
                            <?php endforeach;?>
                        <?php endif; ?>
                    </ul>
                </article>
            </div>

            <div>
                <input id="ac-4" name="accordion-1" type="radio" />
                <label for="ac-4"><img src="<?php echo $_layoutParams['ruta_img'];?>report.png"><span>Reportes</span></label>
                <article class="ac-small">
                    <ul class="listOptions">
                        <?php if(isset($_layoutParams['menuReportes'])):?>
                            <?php foreach($_layoutParams['menuReportes'] as $element): ?>
                                <li><a href="<?php echo $element['enlace'];?>"><?php echo $element['titulo'];?></a></li>
                            <?php endforeach;?>
                        <?php endif; ?>
                    </ul>
                </article>
            </div>
        </section>
    </aside>