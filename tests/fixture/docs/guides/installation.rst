Installation
============

Use independent components together with predictable, explicit contracts.

Requirements
------------

.. important::

   Use PHP 8.3 or later and configure the documentation template before building.

Install a package
-----------------

.. code-block:: bash

   composer require fast-forward/clock

Create an instance
------------------

.. code-block:: php

   <?php

   use FastForward\Documentation\Example;

   $example = new Example();
   echo $example->greet('Dash');

Return to the :doc:`documentation index <../index>`.
