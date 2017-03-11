<?php
	
	
	$first = isset($_POST['first']) ? $_POST['first'] : "" ;
	$second = isset($_POST['second']) ? $_POST['second'] : "" ;
	
	$resultFirst = "" ;
	$resultSecond = "" ;
	
	if ( isset($_POST['one2one'])) {
		$resultFirst = <<<text
		
	/**
	* @ORM\OneToOne(targetEntity="{$second}", mappedBy="{$first}",  cascade={"persist","remove", "detach", "merge", "refresh"})
	*/
	protected \${$second};
	
	

    
    
text;

		$resultSecond = <<<text

	/**
	* @OneToOne(targetEntity="{$first}", inversedBy="{$second}")
	* @JoinColumn(name="{$first}_id", referencedColumnName="id", onDelete="cascade)
	*/
	protected \${$first};
		
	public function set{$first}({$first} \${$first}) { \$this->{$first} = \${$first} ; }
	public function get{$first}(){	return \$this->{$first} ; }
text;
		
	}
	
	if (isset($_POST['one2many'])) {
		
		$resultFirst = <<<text
		
	public function __construct()
	{
		\$this->{$second}s = new ArrayCollection() ;
	}
		
	/**
	* @ORM\OneToMany(targetEntity="{$second}", mappedBy="{$first}", cascade={"persist"}, orphanRemoval=true)
	*/
	protected \${$second}s;
	public function get{$second}s() { return \$this->{$second}s ; }
	public function set{$second}s(ArrayCollection \${$second}s) { \$this->{$second}s = \${$second}s ; }
text;

		$resultSecond = <<<text
		
	/**
	* @ORM\ManyToOne(targetEntity="{$first}", inversedBy="{$second}s", cascade={"persist"})
	* @ORM\JoinColumn(name="{$first}_id", referencedColumnName="id", onDelete="cascade")
	*/
	protected \${$first};
	public function set{$first}({$first} \${$first}) { \$this->{$first} = \${$first} ; }
	public function get{$first}(){ return \$this->{$first} ; }
text;
	}
	
	
	
	if (isset($_POST['many2many'])) {
		
		$resultFirst = <<<text
		
	/**
	* @ORM\ManyToMany(targetEntity="{$second}", inversedBy="{$first}s")
	* @ORM\JoinTable(name="tbl_{$first}_{$second}")
	*/
	private \${$second}s ;
	public function set{$second}s(\${$second}s) { \$this->{$second}s = \${$second}s;}
	public function get{$second}s(){return \$this->{$second}s ;}

text;

		$resultSecond = <<<text
		
	/**
	 * @ORM\ManyToMany(targetEntity="{$first}", mappedBy="{$second}s")
	 */
	private \${$first}s ;
	
	public function get{$first}s () { return \$this->{$first}s ;}
	public function set{$first}s (\${$first}s) { \$this->{$first}s = \${$first}s; }
	

text;
	}
	
	
	
	
	
	
?>



<form action="" method="POST">
	<input name="first" placeholder="First class" value="<?php echo $first;?>" />
	<input name="second" placeholder="Second class" value="<?php echo $second;?>" />

	<input type="submit" name="one2one" value="One2One">
	<input type="submit" name="one2many" value="One2many">
	
	<input type="submit" name="many2many" value="Many2Many">
	
	<fieldset>
		<legend>First: <?php echo $first;?></legend>
		<textarea cols="150" rows="15"><?php echo $resultFirst;?></textarea>
	</fieldset>
	
	<fieldset>
		<legend>Second: <?php echo $second;?></legend>
		<textarea cols="150" rows="15"><?php echo $resultSecond;?></textarea>
	</fieldset>
	
	
</form>

<?php



